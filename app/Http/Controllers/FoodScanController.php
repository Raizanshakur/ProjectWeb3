<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodScanConfirmRequest;
use App\Http\Requests\FoodScanUploadRequest;
use App\Models\Child;
use App\Models\FoodAnalysis;
use App\Services\FoodAnalysisService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FoodScanController extends Controller
{
    public function __construct(
        protected FoodAnalysisService $foodAnalysisService
    ) {
    }

    /**
     * Display the AI food scanner page.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $children = $user->children()->oldest('id')->get();
        $selectedChild = null;

        if ($request->filled('child_id')) {
            $child = Child::findOrFail($request->input('child_id'));
            abort_unless($child->user_id === $user->id, 403);
            $selectedChild = $child;
        } else {
            $selectedChild = $children->first();
        }

        $recentAnalyses = $user->foodAnalyses()
            ->with('mealRecord')
            ->latest()
            ->take(6)
            ->get();

        return view('food-scan', compact('children', 'selectedChild', 'recentAnalyses'));
    }

    /**
     * Handle food image upload and start analysis.
     */
    public function store(FoodScanUploadRequest $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $file = $request->file('image');
        $childId = $request->input('child_id');

        // Jika request sync diminta atau saat unit test / environment sync
        $sync = $request->boolean('sync') || config('queue.default') === 'sync';

        $analysis = $this->foodAnalysisService->createAnalysis($user, $file, $childId, $sync);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'analysis_id' => $analysis->id,
                'status' => $analysis->status,
                'data' => $this->formatAnalysisResponse($analysis),
            ], 201);
        }

        return redirect()
            ->route('food.scan.show', $analysis)
            ->with('success', 'Foto makanan berhasil diunggah dan sedang dianalisis.');
    }

    /**
     * Get analysis status for polling.
     */
    public function status(FoodAnalysis $analysis): JsonResponse
    {
        abort_unless($analysis->user_id === Auth::id(), 403);

        return response()->json([
            'id' => $analysis->id,
            'status' => $analysis->status,
            'is_confirmed' => $analysis->mealRecord()->exists(),
            'data' => $this->formatAnalysisResponse($analysis),
        ]);
    }

    /**
     * Display details of a specific food analysis.
     */
    public function show(FoodAnalysis $analysis): View
    {
        abort_unless($analysis->user_id === Auth::id(), 403);

        $user = Auth::user();
        $children = $user->children()->oldest('id')->get();
        $analysis->load('mealRecord');

        return view('food-scan-show', compact('analysis', 'children'));
    }

    /**
     * Serve private food image file securely to authorized user.
     */
    public function image(FoodAnalysis $analysis): BinaryFileResponse
    {
        abort_unless($analysis->user_id === Auth::id(), 403);
        abort_unless(
            $analysis->food_image && Storage::disk('local')->exists($analysis->food_image),
            404
        );

        return response()->file(Storage::disk('local')->path($analysis->food_image));
    }

    /**
     * Confirm analysis and create a MealRecord (idempotent).
     */
    public function confirm(FoodScanConfirmRequest $request, FoodAnalysis $analysis): JsonResponse|RedirectResponse
    {
        abort_unless($analysis->user_id === Auth::id(), 403);

        $mealRecord = $this->foodAnalysisService->confirmMeal(
            $analysis,
            Auth::user(),
            $request->validated()
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Catatan makanan berhasil dikonfirmasi ke riwayat nutrisi.',
                'meal_record_id' => $mealRecord->id,
            ]);
        }

        return redirect()
            ->route('nutrition', [
                'child_id' => $mealRecord->child_id,
                'date' => Carbon::parse($mealRecord->consumed_at, config('app.timezone'))->format('Y-m-d'),
            ])
            ->with('success', 'Catatan makanan dari hasil scan berhasil ditambahkan ke nutrisi.');
    }

    /**
     * Delete an analysis record and its image.
     */
    public function destroy(FoodAnalysis $analysis): JsonResponse|RedirectResponse
    {
        abort_unless($analysis->user_id === Auth::id(), 403);

        $this->foodAnalysisService->deleteAnalysis($analysis, Auth::user());

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('food.scan')
            ->with('success', 'Hasil analisis berhasil dihapus.');
    }

    /**
     * Format analysis payload for JSON response.
     */
    protected function formatAnalysisResponse(FoodAnalysis $analysis): array
    {
        return [
            'id' => $analysis->id,
            'status' => $analysis->status,
            'is_food' => (bool) $analysis->is_food,
            'food_name' => $analysis->food_name,
            'portion_description' => $analysis->portion_description,
            'visible_ingredients' => $analysis->visible_ingredients ?? [],
            'calories' => $analysis->calories !== null ? (float) $analysis->calories : null,
            'protein' => $analysis->protein !== null ? (float) $analysis->protein : null,
            'carbohydrates' => $analysis->carbohydrates !== null ? (float) $analysis->carbohydrates : null,
            'fat' => $analysis->fat !== null ? (float) $analysis->fat : null,
            'fiber' => $analysis->fiber !== null ? (float) $analysis->fiber : null,
            'uncertainty_note' => $analysis->uncertainty_note,
            'ai_analysis' => $analysis->ai_analysis,
            'error_message' => $analysis->error_message,
            'model_used' => $analysis->model_used,
            'analyzed_at' => $analysis->analyzed_at?->toIso8601String(),
        ];
    }
}
