<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root
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

        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/consultations', [DoctorConsultationController::class, 'index'])
            ->name('consultations');

        Route::get('/consultations/{id}', [DoctorConsultationController::class, 'show'])
            ->name('consultations.show');

        Route::get('/profile', [DoctorProfileController::class, 'index'])
            ->name('profil');

        Route::put('/profile', [DoctorProfileController::class, 'update'])
            ->name('profil.update');
    });

/*
|--------------------------------------------------------------------------
| SHARED ROUTES (both roles)
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
| DOKTER / ADMIN
|--------------------------------------------------------------------------
*/

// Login dokter (tanpa middleware auth)
Route::get('/dokter/login', [DoctorAuthController::class, 'showLogin'])
    ->name('dokter.login');

Route::post('/dokter/login', [DoctorAuthController::class, 'login'])
    ->name('dokter.login.submit');

// Halaman dokter (placeholder — belum pakai middleware auth khusus dokter)
Route::prefix('dokter')->group(function () {

    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
        ->name('dokter.dashboard');

    Route::get('/konsultasi', [DoctorConsultationController::class, 'index'])
        ->name('dokter.konsultasi');

    Route::get('/konsultasi/{id}', [DoctorConsultationController::class, 'show'])
        ->name('dokter.konsultasi.detail');

    Route::get('/pasien', [DoctorPatientsController::class, 'index'])
        ->name('dokter.pasien');

    Route::get('/profil', [DoctorProfileController::class, 'index'])
        ->name('dokter.profil');

    Route::patch('/profil', [DoctorProfileController::class, 'update'])
        ->name('dokter.profil.update');

    Route::post('/logout', [DoctorAuthController::class, 'logout'])
        ->name('dokter.logout');

});


require __DIR__.'/auth.php';