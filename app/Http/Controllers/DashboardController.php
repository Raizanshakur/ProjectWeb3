<?php

namespace App\Http\Controllers;

use App\Services\DashboardSummaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardSummaryService $summaryService
    ) {}

    /**
     * Menampilkan dashboard utama Parent dengan pilihan anak aktif dan data terintegrasi.
     *
     * Alur:
     * 1. Mengambil seluruh anak milik parent yang sedang login (diurutkan latest).
     * 2. Menentukan $selectedChild berdasarkan parameter ?child_id={id} atau default anak pertama.
     * 3. Memverifikasi kepemilikan ketat (404 jika bukan milik parent login).
     * 4. Menghitung ringkasan nutrisi hari ini, pengukuran terbaru, status grafik, dan aktivitas terbaru anak aktif.
     * 5. Mengirimkan variabel ke view dashboard secara lengkap dan aman.
     */
    public function index(Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil daftar anak milik parent yang sedang login
        $children = $user->children()->latest()->get();

        $selectedChild = null;

        if ($request->filled('child_id')) {
            $childId = (int) $request->input('child_id');
            $selectedChild = $children->firstWhere('id', $childId);

            if (!$selectedChild) {
                abort(404, 'Data anak tidak ditemukan atau bukan milik Anda.');
            }
        } else {
            $selectedChild = $children->first();
        }

        if ($selectedChild) {
            $summary = $this->summaryService->getSummaryForChild($selectedChild);

            $dailyTotals = $summary['nutrition'];
            $targetCalories = $summary['nutrition']['target_calories'];
            $caloriePercentage = $summary['nutrition']['calorie_percentage'];
            $progressBarWidth = $summary['nutrition']['progress_bar_width'];

            $latestGrowthRecord = $summary['growth']['latest_record'];
            $growthChartData = $summary['growth']['chart_data'];
            $chartData = $growthChartData; // alias konsistensi
            $hasMonthlyRecord = $summary['growth']['has_monthly_record'];

            $recentActivities = $summary['recentActivities'];
        } else {
            $dailyTotals = [
                'calories' => 0.0,
                'protein' => 0.0,
                'fat' => 0.0,
                'carbohydrates' => 0.0,
                'count' => 0,
                'target_calories' => 0,
                'calorie_percentage' => 0,
                'progress_bar_width' => 0,
                'has_unspecified_calories' => false,
            ];
            $targetCalories = 0;
            $caloriePercentage = 0;
            $progressBarWidth = 0;

            $latestGrowthRecord = null;
            $growthChartData = ['labels' => [], 'weights' => [], 'heights' => []];
            $chartData = $growthChartData;
            $hasMonthlyRecord = false;

            $recentActivities = collect();
        }

        return view('dashboard', compact(
            'children',
            'selectedChild',
            'dailyTotals',
            'targetCalories',
            'caloriePercentage',
            'progressBarWidth',
            'latestGrowthRecord',
            'growthChartData',
            'chartData',
            'hasMonthlyRecord',
            'recentActivities'
        ));
    }
}
