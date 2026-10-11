<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChildController extends Controller
{
    public function index()
    {
        $children = Auth::user()
            ->children()
            ->with('latestGrowthRecord')
            ->latest()
            ->get();

        return view('children.index', compact('children'));
    }


    public function create()
    {
        return view('children.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'gender' => [
                'required',
                Rule::in(['L', 'P'])
            ],

            'birth_date' => [
                'required',
                'date',
                'before_or_equal:today'
            ],

            'birth_weight' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99.99'
            ],

            'birth_height' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99.99'
            ],
        ]);


        Auth::user()
            ->children()
            ->create($validated);


        return redirect()
            ->route('children.index')
            ->with(
                'success',
                'Data anak berhasil ditambahkan.'
            );
    }


    public function show(Child $child)
    {
        $this->authorizeChild($child);

        $records = $child->growthRecords()
            ->orderBy('measurement_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $latestRecord = $records->first();

        $chronological = $records->sortBy([
            ['measurement_date', 'asc'],
            ['id', 'asc'],
        ])->values();

        $chartData = [
            'labels' => $chronological->map(fn ($r) => $r->measurement_date ? $r->measurement_date->translatedFormat('d M Y') : '')->all(),
            'weights' => $chronological->map(fn ($r) => (float) $r->weight)->all(),
            'heights' => $chronological->map(fn ($r) => (float) $r->height)->all(),
        ];

        // Dokter konsultasi terakhir
        $latestConsultation = $child->consultations()
            ->with('doctor')
            ->whereNotNull('doctor_id')
            ->latest('created_at')
            ->first();

        $assignedDoctor = $latestConsultation?->doctor;

        // Status nutrisi & aktivitas aktual
        $hasMeals = $child->mealRecords()->exists();
        $todayMealsCount = $child->mealRecords()
            ->whereBetween('consumed_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();

        $nutritionStatus = match (true) {
            $todayMealsCount > 0 => 'Tercatat hari ini',
            $hasMeals => 'Pernah tercatat',
            default => 'Belum ada data',
        };

        $activityStatus = ($records->isNotEmpty() || $hasMeals || $child->consultations()->exists())
            ? 'Aktif'
            : 'Belum ada aktivitas';

        return view(
            'children.show',
            compact('child', 'records', 'latestRecord', 'chartData', 'assignedDoctor', 'nutritionStatus', 'activityStatus')
        );
    }


    public function edit(Child $child)
    {
        $this->authorizeChild($child);

        return view(
            'children.edit',
            compact('child')
        );
    }


    public function update(
        Request $request,
        Child $child
    ) {
        $this->authorizeChild($child);


        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'gender' => [
                'required',
                Rule::in(['L', 'P'])
            ],

            'birth_date' => [
                'required',
                'date',
                'before_or_equal:today'
            ],

            'birth_weight' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99.99'
            ],

            'birth_height' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99.99'
            ],
        ]);


        $child->update($validated);


        return redirect()
            ->route('children.index')
            ->with(
                'success',
                'Data anak berhasil diperbarui.'
            );
    }


    public function destroy(Child $child)
    {
        $this->authorizeChild($child);

        $child->delete();


        return redirect()
            ->route('children.index')
            ->with(
                'success',
                'Data anak berhasil dihapus.'
            );
    }


    private function authorizeChild(Child $child): void
    {
        abort_unless(
            $child->user_id === Auth::id(),
            403
        );
    }
}