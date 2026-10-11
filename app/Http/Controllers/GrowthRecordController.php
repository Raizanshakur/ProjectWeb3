<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrowthRecordRequest;
use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GrowthRecordController extends Controller
{
    /**
     * Display a listing of growth records for a child.
     */
    public function index(Child $child): View
    {
        $this->authorizeChild($child);

        $records = $child->growthRecords()
            ->orderBy('measurement_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $latestRecord = $records->first();

        return view('growth.index', compact('child', 'records', 'latestRecord'));
    }

    /**
     * Show the form for creating a new growth record.
     */
    public function create(Child $child): View
    {
        $this->authorizeChild($child);

        return view('growth.create', compact('child'));
    }

    /**
     * Store a newly created growth record in storage.
     */
    public function store(GrowthRecordRequest $request, Child $child): RedirectResponse
    {
        $this->authorizeChild($child);

        $child->growthRecords()->create($request->validated());

        return redirect()
            ->route('children.growth-records.index', $child)
            ->with('success', 'Data pengukuran pertumbuhan berhasil ditambahkan.');
    }

    /**
     * Display the specified growth record.
     */
    public function show(Child $child, GrowthRecord $record): RedirectResponse
    {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        return redirect()->route('children.growth-records.index', $child);
    }

    /**
     * Show the form for editing the specified growth record.
     */
    public function edit(Child $child, GrowthRecord $record): View
    {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        return view('growth.edit', compact('child', 'record'));
    }

    /**
     * Update the specified growth record in storage.
     */
    public function update(
        GrowthRecordRequest $request,
        Child $child,
        GrowthRecord $record
    ): RedirectResponse {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        $record->update($request->validated());

        return redirect()
            ->route('children.growth-records.index', $child)
            ->with('success', 'Data pengukuran pertumbuhan berhasil diperbarui.');
    }

    /**
     * Remove the specified growth record from storage.
     */
    public function destroy(Child $child, GrowthRecord $record): RedirectResponse
    {
        $this->authorizeChild($child);
        $this->authorizeRecord($child, $record);

        $record->delete();

        return redirect()
            ->route('children.growth-records.index', $child)
            ->with('success', 'Data pengukuran pertumbuhan berhasil dihapus.');
    }

    /**
     * Ensure the authenticated parent owns the child.
     */
    private function authorizeChild(Child $child): void
    {
        abort_unless($child->user_id === Auth::id(), 403);
    }

    /**
     * Ensure the record belongs to the child specified in the URL.
     */
    private function authorizeRecord(Child $child, GrowthRecord $record): void
    {
        abort_unless($record->child_id === $child->id, 404);
    }
}