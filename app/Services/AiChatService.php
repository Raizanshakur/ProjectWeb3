<?php

namespace App\Services;

use App\Models\AiChat;
use App\Models\Child;
use App\Models\User;
use App\Services\Gemini\GeminiGatewayInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    /**
     * Standard base system prompt for NutriBot AI assistant.
     */
    public const SYSTEM_INSTRUCTION = <<<EOT
Anda adalah NutriBot, asisten AI edukasi nutrisi dan tumbuh kembang anak untuk aplikasi GrowCare.
Pedoman interaksi wajib:
1. Jawab selalu dalam bahasa Indonesia yang hangat, empatik, terstruktur, jelas, dan mudah dipahami orang tua.
2. Lingkup jawaban adalah edukasi seputar nutrisi, gizi seimbang, pola makan sehat, dan tahapan tumbuh kembang anak.
3. Sampaikan ketidakpastian secara transparan apabila data pengukuran, konsumsi, atau konteks dari orang tua belum tercatat atau kurang lengkap. Jangan pernah mengarang data statistik atau pengukuran yang tidak ada.
4. JANGAN PERNAH memberikan diagnosis medis klinis definitif, mengarang hasil kurva WHO tanpa evaluasi klinis resmi, atau meresepkan/menentukan dosis obat tertentu.
5. PANDUAN KEGAWATDARURATAN MEDIS: Apabila orang tua menyampaikan tanda bahaya (seperti anak sesak napas/sulit bernapas, penurunan kesadaran/tidak sadar, kejang sedang berlangsung atau berulang, dehidrasi berat, demam sangat tinggi disertai kejang, muntah terus-menerus, atau reaksi alergi anafilaksis), Anda WAJIB langsung mengarahkan orang tua untuk SEGERA membawa anak ke Instalasi Gawat Darurat (IGD) atau fasilitas kesehatan darurat terdekat. Jangan berikan penanganan rumahan sebagai pengganti pertolongan medis darurat.
6. Berikan saran praktis, bergizi seimbang, dan aplikatif untuk diterapkan di rumah sesuai kelompok usia anak.
EOT;

    /**
     * Maximum previous exchanges to send as context (1 exchange = 1 user + 1 model message).
     */
    protected int $maxHistoryExchanges = 6;

    public function __construct(
        protected GeminiGatewayInterface $geminiGateway
    ) {
    }

    /**
     * Build contextual system instruction for Gemini including selected child profile (without banned PII).
     */
    public function buildSystemInstruction(?Child $child = null): string
    {
        if (! $child) {
            return self::SYSTEM_INSTRUCTION;
        }

        $gender = in_array(strtolower($child->gender), ['l', 'male', 'laki-laki']) ? 'Laki-laki' : 'Perempuan';
        $ageInMonths = $child->age_in_months;
        $formattedAge = $child->formatted_age;

        // Kebutuhan Energi Standar AKG Permenkes No. 28 Tahun 2019 (Single Source of Truth)
        $targetCalories = app(DashboardSummaryService::class)->calculateTargetCalories($child);

        $latestGrowth = $child->latestGrowthRecord;
        if ($latestGrowth) {
            $dateStr = $latestGrowth->measurement_date ? $latestGrowth->measurement_date->format('d/m/Y') : '-';
            $weight = (float) $latestGrowth->weight;
            $height = (float) $latestGrowth->height;
            $growthInfo = "Berat badan: {$weight} kg, Tinggi/panjang badan: {$height} cm (dicatat pada {$dateStr})";
        } else {
            $growthInfo = "Belum ada catatan berat badan dan tinggi badan terbaru untuk anak yang dipilih.";
        }

        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $todayMeals = $child->mealRecords()
            ->whereBetween('consumed_at', [$todayStart, $todayEnd])
            ->get();

        if ($todayMeals->isNotEmpty()) {
            $todayCal = (float) $todayMeals->sum('calories');
            $mealCount = $todayMeals->count();
            $nutritionInfo = "Konsumsi nutrisi tercatat hari ini: {$todayCal} kkal ({$mealCount} catatan makanan). Target harian AKG: {$targetCalories} kkal.";
        } else {
            $nutritionInfo = "Belum tersedia catatan konsumsi makanan untuk hari ini. Standar kebutuhan energi harian AKG: {$targetCalories} kkal.";
        }

        $childContext = <<<CTX

KONTEKS PROFIL ANAK YANG SEDANG DIKONSULTASIKAN:
- Jenis Kelamin: {$gender}
- Usia Anak: {$formattedAge} ({$ageInMonths} bulan)
- Status Pengukuran Terkini: {$growthInfo}
- Status Nutrisi & Kebutuhan Energi Harian: {$nutritionInfo}
Pedoman khusus konteks anak:
- Sesuaikan seluruh rekomendasi gizi, porsi, dan tahapan tekstur makanan dengan usia dan profil di atas.
- Apabila data pengukuran atau riwayat nutrisi belum tercatat, sebutkan secara sopan dan transparan tanpa mengarang angka.
CTX;

        return self::SYSTEM_INSTRUCTION . "\n" . $childContext;
    }

    /**
     * Send a user message to Gemini and persist the verified response.
     *
     * @param User $user
     * @param string $userMessage
     * @param int|null $childId
     * @return AiChat
     *
     * @throws \App\Exceptions\Gemini\GeminiException
     */
    public function sendMessage(User $user, string $userMessage, ?int $childId = null): AiChat
    {
        $sanitizedMessage = trim($userMessage);

        $child = null;
        if ($childId) {
            $child = Child::with(['latestGrowthRecord'])->findOrFail($childId);
            abort_unless($child->user_id === $user->id, 403, 'Akses data anak ditolak.');
        }

        // Ambil riwayat percakapan sebelumnya terisolasi per anak (atau umum jika tanpa anak)
        $previousChatsQuery = AiChat::where('user_id', $user->id);
        if ($childId) {
            $previousChatsQuery->where('child_id', $childId);
        } else {
            $previousChatsQuery->whereNull('child_id');
        }

        $previousChats = $previousChatsQuery->latest('id')
            ->take($this->maxHistoryExchanges)
            ->get()
            ->reverse();

        // Konversi ke format riwayat tanpa menyertakan PII anak (Pemberlakuan Privasi Tier Free)
        $conversationHistory = [];
        foreach ($previousChats as $chat) {
            if (! empty($chat->user_message) && ! empty($chat->ai_response)) {
                $conversationHistory[] = [
                    'role' => 'user',
                    'content' => $chat->user_message,
                ];
                $conversationHistory[] = [
                    'role' => 'model',
                    'content' => $chat->ai_response,
                ];
            }
        }

        $systemInstruction = $this->buildSystemInstruction($child);

        $startTime = microtime(true);
        $modelName = config('services.gemini.chat_model', 'gemini-3.8-flash');

        // Panggil gateway Gemini
        $aiResponse = $this->geminiGateway->generateChatResponse(
            $sanitizedMessage,
            $conversationHistory,
            $systemInstruction
        );

        $duration = round(microtime(true) - $startTime, 3);

        // Audit log operasional aman (tanpa isi teks pesan, prompt, atau key)
        Log::info('AiChat question processed successfully', [
            'user_id' => $user->id,
            'child_id' => $childId,
            'model' => $modelName,
            'history_count' => count($conversationHistory),
            'duration_sec' => $duration,
        ]);

        // Simpan hanya jawaban yang benar-benar berhasil diterima dari Gemini
        return AiChat::create([
            'user_id' => $user->id,
            'child_id' => $childId,
            'user_message' => $sanitizedMessage,
            'ai_response' => $aiResponse,
            'topic' => 'nutrisi_tumbuh_kembang',
            'model_used' => $modelName,
        ]);
    }

    /**
     * Get chronologically ordered chat history for a specific user.
     *
     * @param User $user
     * @param int|null $childId
     * @param int $limit
     * @param bool $onlyGeneral
     * @return Collection<int, AiChat>
     */
    public function getUserChats(User $user, ?int $childId = null, int $limit = 50, bool $onlyGeneral = false): Collection
    {
        $query = AiChat::where('user_id', $user->id)
            ->with('child')
            ->oldest('id');

        if ($childId) {
            $query->where('child_id', $childId);
        } elseif ($onlyGeneral) {
            $query->whereNull('child_id');
        }

        return $query->take($limit)->get();
    }

    /**
     * Clear all chat history belonging to the authenticated user.
     *
     * @param User $user
     * @param int|null $childId
     * @return int Number of deleted messages
     */
    public function clearUserHistory(User $user, ?int $childId = null): int
    {
        $query = AiChat::where('user_id', $user->id);

        if ($childId) {
            $query->where('child_id', $childId);
        }

        $count = $query->count();
        $query->delete();

        Log::info('AiChat history cleared by user', [
            'user_id' => $user->id,
            'deleted_count' => $count,
        ]);

        return $count;
    }
}
