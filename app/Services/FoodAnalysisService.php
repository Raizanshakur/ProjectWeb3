<?php

namespace App\Services;

use App\Exceptions\Gemini\GeminiException;
use App\Jobs\ProcessFoodAnalysisJob;
use App\Models\Child;
use App\Models\FoodAnalysis;
use App\Models\MealRecord;
use App\Models\User;
use App\Services\Gemini\GeminiGatewayInterface;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoodAnalysisService
{
    public function __construct(
        protected GeminiGatewayInterface $geminiGateway
    ) {
    }

    /**
     * Create a new FoodAnalysis record, securely save the uploaded image, and dispatch processing.
     */
    public function createAnalysis(
        User $user,
        UploadedFile $file,
        ?int $childId = null,
        bool $sync = false
    ): FoodAnalysis {
        if ($childId) {
            $child = Child::findOrFail($childId);
            abort_unless($child->user_id === $user->id, 403);
        }

        // Simpan gambar di disk lokal privat dengan nama acak aman
        $extension = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = Str::random(40) . '.' . strtolower($extension);
        $path = $file->storeAs('food_analyses', $filename, 'local');

        $analysis = FoodAnalysis::create([
            'user_id' => $user->id,
            'child_id' => $childId,
            'food_image' => $path,
            'status' => 'pending',
        ]);

        if ($sync) {
            $this->processAnalysis($analysis);
        } else {
            ProcessFoodAnalysisJob::dispatch($analysis);
        }

        return $analysis;
    }

    /**
     * Process the food analysis by calling Gemini via the gateway.
     */
    public function processAnalysis(FoodAnalysis $analysis): FoodAnalysis
    {
        if (! Storage::disk('local')->exists($analysis->food_image)) {
            $analysis->update([
                'status' => 'failed',
                'error_message' => 'Berkas gambar tidak ditemukan di penyimpanan server.',
                'analyzed_at' => now(),
            ]);

            return $analysis;
        }

        $analysis->update(['status' => 'processing']);

        $imageBytes = Storage::disk('local')->get($analysis->food_image);
        $mimeType = Storage::disk('local')->mimeType($analysis->food_image) ?: 'image/jpeg';

        try {
            $result = $this->geminiGateway->analyzeFoodImage($imageBytes, $mimeType);

            $analysis->update([
                'status' => 'succeeded',
                'is_food' => $result['is_food'],
                'food_name' => $result['food_name'],
                'visible_ingredients' => $result['visible_ingredients'],
                'portion_description' => $result['portion_description'],
                'calories' => $result['estimated_calories'],
                'protein' => $result['estimated_protein_g'],
                'carbohydrates' => $result['estimated_carbohydrates_g'],
                'fat' => $result['estimated_fat_g'],
                'fiber' => $result['estimated_fiber_g'],
                'uncertainty_note' => $result['uncertainty_note'],
                'ai_analysis' => $result['analysis_note'],
                'model_used' => $result['model_used'],
                'error_message' => null,
                'analyzed_at' => now(),
            ]);
        } catch (GeminiException $e) {
            Log::warning('Food analysis failed with Gemini exception', [
                'analysis_id' => $analysis->id,
                'exception' => get_class($e),
            ]);

            $analysis->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'analyzed_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Food analysis unexpected failure', [
                'analysis_id' => $analysis->id,
                'error' => $e->getMessage(),
            ]);

            $analysis->update([
                'status' => 'failed',
                'error_message' => 'Terjadi kesalahan sistem saat menganalisis foto makanan.',
                'analyzed_at' => now(),
            ]);
        }

        return $analysis->fresh();
    }

    /**
     * Confirm analysis results and record as an actual MealRecord.
     * Prevents double confirmation (idempotent) and allows parent corrections.
     */
    public function confirmMeal(
        FoodAnalysis $analysis,
        User $user,
        array $overrides = []
    ): MealRecord {
        abort_unless($analysis->user_id === $user->id, 403);
        abort_unless($analysis->status === 'succeeded', 422, 'Hanya analisis yang berhasil yang dapat dikonfirmasi.');
        abort_unless($analysis->is_food, 422, 'Foto yang bukan makanan tidak dapat dicatat ke riwayat nutrisi.');

        try {
            return DB::transaction(function () use ($analysis, $user, $overrides) {
                // Kunci baris FoodAnalysis yang sudah ada untuk mencegah race condition dari dua request paralel
                $lockedAnalysis = FoodAnalysis::where('id', $analysis->id)
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Cek apakah analisis ini sudah pernah dikonfirmasi sebelumnya (idempotensi)
                $existing = MealRecord::where('food_analysis_id', $lockedAnalysis->id)->first();
                if ($existing) {
                    return $existing;
                }

                $targetChildId = $overrides['child_id']
                    ?? $analysis->child_id
                    ?? $user->children()->first()?->id;

                abort_unless($targetChildId, 422, 'Data anak wajib dipilih untuk mencatat makanan.');

                $child = Child::findOrFail($targetChildId);
                abort_unless($child->user_id === $user->id, 403);

                $consumedAt = ! empty($overrides['consumed_at'])
                    ? Carbon::parse($overrides['consumed_at'], config('app.timezone'))
                    : now();

                if ($child->birth_date && $consumedAt->lt($child->birth_date)) {
                    abort(422, 'Waktu konsumsi tidak boleh sebelum tanggal lahir anak.');
                }

                if ($consumedAt->gt(now())) {
                    abort(422, 'Waktu konsumsi tidak boleh di masa depan.');
                }

                return MealRecord::create([
                    'user_id' => $user->id,
                    'child_id' => $child->id,
                    'food_analysis_id' => $analysis->id,
                    'food_name' => ! empty($overrides['food_name']) ? trim($overrides['food_name']) : ($analysis->food_name ?: 'Makanan Hasil Scan'),
                    'meal_type' => $overrides['meal_type'] ?? 'Sarapan',
                    'portion_text' => isset($overrides['portion_text']) ? $overrides['portion_text'] : $analysis->portion_description,
                    'consumed_at' => $consumedAt,
                    'calories' => array_key_exists('calories', $overrides) ? $overrides['calories'] : $analysis->calories,
                    'protein' => array_key_exists('protein', $overrides) ? $overrides['protein'] : $analysis->protein,
                    'carbohydrates' => array_key_exists('carbohydrates', $overrides) ? $overrides['carbohydrates'] : $analysis->carbohydrates,
                    'fat' => array_key_exists('fat', $overrides) ? $overrides['fat'] : $analysis->fat,
                    'fiber' => array_key_exists('fiber', $overrides) ? $overrides['fiber'] : $analysis->fiber,
                    'source' => 'scan',
                    'notes' => $overrides['notes'] ?? $analysis->uncertainty_note,
                ]);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi concurrent race condition yang memicu unique constraint,
            // kembalikan record yang berhasil dibuat oleh request yang bersaing tanpa melempar error 500.
            $existing = MealRecord::where('food_analysis_id', $analysis->id)->first();
            if ($existing) {
                return $existing;
            }

            throw $e;
        }
    }

    /**
     * Delete a FoodAnalysis record and its underlying private image file.
     */
    public function deleteAnalysis(FoodAnalysis $analysis, User $user): bool
    {
        abort_unless($analysis->user_id === $user->id, 403);

        if ($analysis->food_image && Storage::disk('local')->exists($analysis->food_image)) {
            Storage::disk('local')->delete($analysis->food_image);
        }

        return (bool) $analysis->delete();
    }
}
