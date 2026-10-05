
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorConsultationController;
use App\Http\Controllers\Doctor\DoctorPatientsController;
use App\Http\Controllers\Doctor\DoctorProfileController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isDoctor()
            ? redirect()->route('dokter.dashboard')
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| PARENT ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:parent'])->group(function () {

    Route::get('/dashboard', function () {
        $children = auth()->user()
            ->children()
            ->latest()
            ->get();

        $selectedChild = $children->first();

        return view('dashboard', compact(
            'children',
            'selectedChild'
        ));
    })->name('dashboard');

    Route::get('/nutrition', function () {
        return view('nutrition');
    })->name('nutrition');

    Route::get('/food-scan', function () {
        return view('food-scan');
    })->name('food.scan');

    Route::get('/tanya-ai', function () {
        return view('ai-chat');
    })->name('ai.chat');

    Route::resource('children', ChildController::class);
});


/*
|--------------------------------------------------------------------------
| DOCTOR ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:doctor'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {

        // Dashboard Dokter
        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
            ->name('dashboard');

        // Konsultasi
        Route::get('/konsultasi', [DoctorConsultationController::class, 'index'])
            ->name('konsultasi');

        Route::get('/konsultasi/{id}', [DoctorConsultationController::class, 'show'])
            ->name('konsultasi.detail');

        // Pasien
        Route::get('/pasien', [DoctorPatientsController::class, 'index'])
            ->name('pasien');

        // Profil
        Route::get('/profil', [DoctorProfileController::class, 'index'])
            ->name('profil');

        Route::patch('/profil', [DoctorProfileController::class, 'update'])
            ->name('profil.update');
    });


/*
|--------------------------------------------------------------------------
| SHARED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

