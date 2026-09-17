<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrowthRecordController extends Controller
{
    public function index(Child $child)
    {
        $this->authorizeChild($child);

        $records = $child->growthRecords()
            ->orderBy('measurement_date', 'desc')
            ->get();

        return view('growth.index', compact('child', 'records'));
    }

    public function create(Child $child)
    {
        $this->authorizeChild($child);

        return view('growth.create', compact('child'));
    }

    public function store(Request $request, Child $child)
    {
        $this->authorizeChild($child);

        $validated = $request->validate([
            'measurement_date' => ['required', 'date', 'before_or_equal:today'],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200'],
            'height' => ['required', 'numeric', 'min:1', 'max:250'],
            'head_circumference' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'nutrition_status' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $child->growthRecords()->create($validated);

        return redirect()
            ->route('growth.index', $child)
            ->with('success', 'Data pertumbuhan berhasil ditambahkan.');
    }

    public function edit(Child $child, GrowthRecord $record)
    {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        return view('growth.edit', compact('child', 'record'));
    }

    public function update(
        Request $request,
        Child $child,
        GrowthRecord $record
    ) {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        $validated = $request->validate([
            'measurement_date' => ['required', 'date', 'before_or_equal:today'],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:200'],
            'height' => ['required', 'numeric', 'min:1', 'max:250'],
            'head_circumference' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'nutrition_status' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $record->update($validated);

        return redirect()
            ->route('growth.index', $child)
            ->with('success', 'Data pertumbuhan berhasil diperbarui.');
    }

    public function destroy(Child $child, GrowthRecord $record)
    {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        $record->delete();

        return redirect()
            ->route('growth.index', $child)
            ->with('success', 'Data pertumbuhan berhasil dihapus.');
    }

    private function authorizeChild(Child $child): void
    {
        abort_unless($child->user_id === Auth::id(), 403);
    }

    private function authorizeRecord(
        Child $child,
        GrowthRecord $record
    ): void {
        abort_unless($record->child_id === $child->id, 404);
    }
}