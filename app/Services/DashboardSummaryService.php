<?php

namespace App\Services;

use App\Models\Child;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardSummaryService
{
    /**
     * Mengambil seluruh ringkasan data dashboard untuk anak yang aktif.
     */
    public function getSummaryForChild(Child $child): array
    {
        $tz = config('app.timezone', 'UTC');

        // 1. Nutrisi Hari Ini
        $nutrition = $this->getTodayNutritionSummary($child, $tz);

        // 2. Data Pertumbuhan & Pengukuran
        $growth = $this->getGrowthSummary($child, $tz);

        // 3. Aktivitas Terbaru
        $recentActivities = $this->getRecentActivities($child);

        return [
            'nutrition' => $nutrition,
            'growth' => $growth,
            'recentActivities' => $recentActivities,
        ];
    }

    /**
     * Hitung total nutrisi dan target kalori untuk tanggal tertentu.
     */
    public function getNutritionSummaryForDate(Child $child, Carbon|string $date, ?string $tz = null): array
    {
        $tz = $tz ?: config('app.timezone', 'Asia/Jakarta');
        $parsedDate = $date instanceof Carbon ? $date->copy() : Carbon::parse($date, $tz);
        $startOfDay = $parsedDate->copy()->startOfDay();
        $endOfDay = $parsedDate->copy()->endOfDay();

        $meals = $child->mealRecords()
            ->whereBetween('consumed_at', [$startOfDay, $endOfDay])
            ->get();

        $count = $meals->count();
        $calories = (float) $meals->sum('calories');
        $protein = (float) $meals->sum('protein');
        $fat = (float) $meals->sum('fat');
        $carbohydrates = (float) $meals->sum('carbohydrates');
        $fiber = (float) $meals->sum('fiber');

        // Target kalori berdasarkan Angka Kecukupan Gizi (AKG) Permenkes RI No. 28 Tahun 2019
        $targetCalories = $this->calculateTargetCalories($child);

        $caloriePercentage = 0;
        $progressBarWidth = 0;

        if ($targetCalories > 0 && $count > 0) {
            $caloriePercentage = (int) round(($calories / $targetCalories) * 100);
            $progressBarWidth = min(100, max(0, $caloriePercentage));
        }

        return [
            'calories' => $calories,
            'protein' => $protein,
            'fat' => $fat,
            'carbohydrates' => $carbohydrates,
            'fiber' => $fiber,
            'count' => $count,
            'target_calories' => $targetCalories,
            'calorie_percentage' => $caloriePercentage,
            'progress_bar_width' => $progressBarWidth,
            'has_unspecified_calories' => $meals->contains(fn ($m) => $m->calories === null),
        ];
    }

    /**
     * Hitung total nutrisi dan target kalori hari ini.
     */
    public function getTodayNutritionSummary(Child $child, ?string $tz = null): array
    {
        $tz = $tz ?: config('app.timezone', 'Asia/Jakarta');
        return $this->getNutritionSummaryForDate($child, Carbon::now($tz), $tz);
    }

    /**
     * Estimasi kebutuhan energi harian anak (kkal) berdasarkan Permenkes RI No. 28/2019.
     * Batas usia:
     * - Bayi 0-5 bulan (< 6 bln): 550 kkal
     * - Bayi 6-11 bulan (< 12 bln): 800 kkal
     * - Anak 1-3 tahun (12-47 bulan, < 48 bln): 1350 kkal
     * - Anak 4-6 tahun (48-83 bulan, < 84 bln): 1400 kkal
     * - Anak 7-9 tahun (84-119 bulan, < 120 bln): 1650 kkal
     * - Anak 10-12 tahun (120-155 bulan, < 156 bln): Laki-laki 2000 kkal, Perempuan 1900 kkal
     * - Anak 13-15 tahun (156-191 bulan, < 192 bln): Laki-laki 2400 kkal, Perempuan 2050 kkal
     * - Anak 16-18 tahun (192-227 bulan, < 228 bln): Laki-laki 2650 kkal, Perempuan 2100 kkal
     * - Usia >= 228 bulan (> 18 tahun / di luar rentang anak): 0 (tidak ada target AKG anak)
     */
    public function calculateTargetCalories(Child $child): int
    {
        if (! $child->birth_date) {
            return 0;
        }

        $ageInMonths = $child->age_in_months;
        $gender = strtoupper((string) $child->gender);

        return match (true) {
            $ageInMonths < 6 => 550,
            $ageInMonths < 12 => 800,
            $ageInMonths < 48 => 1350,
            $ageInMonths < 84 => 1400,
            $ageInMonths < 120 => 1650,
            $ageInMonths < 156 => ($gender === 'P' ? 1900 : 2000),
            $ageInMonths < 192 => ($gender === 'P' ? 2050 : 2400),
            $ageInMonths < 228 => ($gender === 'P' ? 2100 : 2650),
            default => 0,
        };
    }

    /**
     * Mengambil ringkasan pengukuran dan grafik pertumbuhan.
     */
    public function getGrowthSummary(Child $child, string $tz): array
    {
        // Pengukuran terbaru berdasarkan tanggal pencatatan
        $latestRecord = $child->growthRecords()
            ->orderBy('measurement_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        // Riwayat kronologis untuk grafik
        $chronologicalRecords = $child->growthRecords()
            ->orderBy('measurement_date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $chartData = [
            'labels' => $chronologicalRecords->map(fn ($r) => $r->measurement_date ? $r->measurement_date->translatedFormat('d M Y') : '')->all(),
            'weights' => $chronologicalRecords->map(fn ($r) => (float) $r->weight)->all(),
            'heights' => $chronologicalRecords->map(fn ($r) => (float) $r->height)->all(),
        ];

        // Periksa apakah ada pengukuran bulan kalender berjalan
        $startOfMonth = Carbon::now($tz)->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now($tz)->endOfMonth()->toDateString();

        $hasMonthlyRecord = $child->growthRecords()
            ->whereBetween('measurement_date', [$startOfMonth, $endOfMonth])
            ->exists();

        return [
            'latest_record' => $latestRecord,
            'total_records' => $chronologicalRecords->count(),
            'has_monthly_record' => $hasMonthlyRecord,
            'chart_data' => $chartData,
            'records' => $chronologicalRecords,
        ];
    }

    /**
     * Mengambil aktivitas terbaru khusus untuk anak yang aktif.
     */
    public function getRecentActivities(Child $child): Collection
    {
        $activities = collect();

        // 1. Catatan makanan terbaru
        $meals = $child->mealRecords()
            ->latest('consumed_at')
            ->limit(5)
            ->get();

        foreach ($meals as $meal) {
            $mealType = ucfirst(str_replace('_', ' ', $meal->meal_type));
            $caloriesText = $meal->calories !== null ? ((int) $meal->calories . ' kkal') : null;

            $activities->push([
                'type' => 'meal',
                'title' => 'Catatan Makan: ' . $meal->food_name,
                'description' => $mealType . ($caloriesText ? " • {$caloriesText}" : ''),
                'timestamp' => $meal->consumed_at ?? $meal->created_at,
                'time_label' => ($meal->consumed_at ?? $meal->created_at)?->diffForHumans(),
                'icon' => 'utensils',
                'icon_bg' => 'bg-[#E7F5F2]',
                'icon_color' => 'text-[#438F83]',
            ]);
        }

        // 2. Catatan pertumbuhan terbaru
        $growths = $child->growthRecords()
            ->orderBy('measurement_date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        foreach ($growths as $growth) {
            $statusText = $growth->nutrition_status ? " ({$growth->nutrition_status})" : '';

            $activities->push([
                'type' => 'growth',
                'title' => 'Pengukuran Pertumbuhan',
                'description' => "Berat: {$growth->weight} kg • Tinggi: {$growth->height} cm{$statusText}",
                'timestamp' => $growth->created_at ?? ($growth->measurement_date ? Carbon::parse($growth->measurement_date) : null),
                'time_label' => $growth->measurement_date ? Carbon::parse($growth->measurement_date)->translatedFormat('d M Y') : $growth->created_at?->diffForHumans(),
                'icon' => 'scale',
                'icon_bg' => 'bg-green-50',
                'icon_color' => 'text-green-600',
            ]);
        }

        // 3. Konsultasi dokter terkait anak
        $consultations = $child->consultations()
            ->with('doctor')
            ->latest('created_at')
            ->limit(5)
            ->get();

        foreach ($consultations as $consultation) {
            $statusLabel = match ($consultation->status) {
                'pending' => 'Menunggu konfirmasi',
                'accepted' => 'Diterima',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => $consultation->status,
            };

            $doctorName = $consultation->doctor?->name ?? 'Dokter Anak';

            $activities->push([
                'type' => 'consultation',
                'title' => 'Konsultasi: ' . $doctorName,
                'description' => 'Status: ' . $statusLabel,
                'timestamp' => $consultation->created_at,
                'time_label' => $consultation->created_at?->diffForHumans(),
                'icon' => 'stethoscope',
                'icon_bg' => 'bg-blue-50',
                'icon_color' => 'text-blue-600',
            ]);
        }

        return $activities
            ->sortByDesc(fn ($item) => $item['timestamp'] ? Carbon::parse($item['timestamp'])->timestamp : 0)
            ->take(4)
            ->values();
    }
}
