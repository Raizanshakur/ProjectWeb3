<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\GrowthRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        if ($request->user()->isDoctor()) {
            return redirect()->route('dokter.profil');
        }

        $user = $request->user();
        $childrenCount = $user->children()->count();
        $assessmentCount = GrowthRecord::whereIn('child_id', $user->children()->select('id'))->count();
        $foodScanCount = $user->foodAnalyses()->count();

        return view('profile.edit', [
            'user' => $user,
            'childrenCount' => $childrenCount,
            'assessmentCount' => $assessmentCount,
            'foodScanCount' => $foodScanCount,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $redirectRoute = $request->user()->isDoctor() ? 'dokter.profil' : 'profile.edit';

        return Redirect::route($redirectRoute)->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $imagePaths = $user->foodAnalyses()
            ->whereNotNull('food_image')
            ->pluck('food_image')
            ->all();

        Auth::logout();

        $user->delete();

        foreach ($imagePaths as $path) {
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

