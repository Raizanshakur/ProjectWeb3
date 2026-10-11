<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealRecordRequest;
use App\Models\Child;
use App\Models\MealRecord;
use App\Services\DashboardSummaryService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NutritionController extends Controller
{
    /**
     * Display the nutrition log and daily summary for the selected child.
     */
    public function index(Request $request, DashboardSummaryService $summaryService): View
    {
        $user = Auth::user();
        $children = $user->children()->oldest('id')->get();

        $selectedChild = null;
        if ($request->filled('child_id')) {
            $child = Child::find($request->input('child_id'));
            if ($child) {
                abort_unless($child->user_id === $user->id, 403);
                $selectedChild = $child;
            } else {
                abort(404);
            }
        } else {
            $selectedChild = $children->first();
        }

        $tz = config('app.timezone', 'UTC');
        $dateInput = $request->input('date');

        try {
            $selectedDate = $dateInput
                ? Carbon::createFromFormat('Y-m-d', $dateInput, $tz)->format('Y-m-d')
                : Carbon::now($tz)->format('Y-m-d');
        } catch (\Exception $e) {
            $selectedDate = Carbon::now($tz)->format('Y-m-d');
        }

        $startOfDay = Carbon::createFromFormat('Y-m-d', $selectedDate, $tz)->startOfDay();
        $endOfDay = Carbon::createFromFormat('Y-m-d', $selectedDate, $tz)->endOfDay();

        if ($selectedChild) {
            // Hitung ringkasan nutrisi menggunakan single source of truth dari DashboardSummaryService
            $dailyTotals = $summaryService->getNutritionSummaryForDate($selectedChild, $selectedDate, $tz);

            $listQuery = $selectedChild->mealRecords()
                ->whereBetween('consumed_at', [$startOfDay, $endOfDay]);

            // Filter pencarian nama makanan bila ada
            if ($request->filled('search')) {
                $listQuery->where('food_name', 'like', '%' . $request->input('search') . '%');
            }

            $meals = $listQuery
                ->orderBy('consumed_at', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString();
        } else {
            $meals = new LengthAwarePaginator([], 0, 10);
            $dailyTotals = [
                'calories' => 0.0,
                'protein' => 0.0,
                'carbohydrates' => 0.0,
                'fat' => 0.0,
                'fiber' => 0.0,
                'count' => 0,
                'target_calories' => 0,
                'calorie_percentage' => 0,
                'progress_bar_width' => 0,
                'has_unspecified_calories' => false,
            ];
        }

        return view('nutrition', compact(
            'children',
            'selectedChild',
            'selectedDate',
            'meals',
            'dailyTotals'
        ));
    }

    /**
     * Store a new meal record.
     */
    public function store(MealRecordRequest $request, ?Child $child = null): RedirectResponse
    {
        $user = Auth::user();
        $targetChildId = $child ? $child->id : $request->input('child_id');

        $targetChild = Child::findOrFail($targetChildId);
        abort_unless($targetChild->user_id === $user->id, 403);

        $validated = $request->validated();
        $validated['user_id'] = $user->id;
        $validated['child_id'] = $targetChild->id;
        $validated['source'] = 'manual';

        $record = MealRecord::create($validated);

        return redirect()
            ->route('nutrition', [
                'child_id' => $targetChild->id,
                'date' => Carbon::parse($record->consumed_at, config('app.timezone'))->format('Y-m-d'),
            ])
            ->with('success', 'Catatan makanan berhasil disimpan.');
    }

    /**
     * Store a new meal record via nested child route.
     */
    public function storeForChild(MealRecordRequest $request, Child $child): RedirectResponse
    {
        return $this->store($request, $child);
    }

    /**
     * Update an existing meal record.
     */
    public function update(
        MealRecordRequest $request,
        MealRecord $meal,
        ?Child $child = null
    ): RedirectResponse {
        $user = Auth::user();

        if ($child) {
            abort_unless($child->user_id === $user->id, 403);
            abort_unless($meal->child_id === $child->id, 404);
        }

        abort_unless($meal->user_id === $user->id, 403);

        $validated = $request->validated();
        unset($validated['user_id'], $validated['child_id'], $validated['source']);

        $meal->update($validated);

        return redirect()
            ->route('nutrition', [
                'child_id' => $meal->child_id,
                'date' => Carbon::parse($meal->consumed_at, config('app.timezone'))->format('Y-m-d'),
            ])
            ->with('success', 'Catatan makanan berhasil diperbarui.');
    }

    /**
     * Update an existing meal record via nested child route.
     */
    public function updateForChild(
        MealRecordRequest $request,
        Child $child,
        MealRecord $meal
    ): RedirectResponse {
        return $this->update($request, $meal, $child);
    }

    /**
     * Delete a meal record.
     */
    public function destroy(
        Request $request,
        MealRecord $meal,
        ?Child $child = null
    ): RedirectResponse {
        $user = Auth::user();

        if ($child) {
            abort_unless($child->user_id === $user->id, 403);
            abort_unless($meal->child_id === $child->id, 404);
        }

        abort_unless($meal->user_id === $user->id, 403);

        $childId = $meal->child_id;
        $date = Carbon::parse($meal->consumed_at, config('app.timezone'))->format('Y-m-d');

        $meal->delete();

        return redirect()
            ->route('nutrition', [
                'child_id' => $childId,
                'date' => $date,
            ])
            ->with('success', 'Catatan makanan berhasil dihapus.');
    }

    /**
     * Delete a meal record via nested child route.
     */
    public function destroyForChild(
        Request $request,
        Child $child,
        MealRecord $meal
    ): RedirectResponse {
        return $this->destroy($request, $meal, $child);
    }
}
