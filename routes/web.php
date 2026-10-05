<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\Doctor\DoctorAuthController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorConsultationController;
use App\Http\Controllers\Doctor\DoctorPatientsController;
use App\Http\Controllers\Doctor\DoctorProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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

})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| NUTRISI
|--------------------------------------------------------------------------
*/

Route::get('/nutrition', function () {
    return view('nutrition');
})->middleware(['auth'])->name('nutrition');

Route::get('/food-scan', function () {
    return view('food-scan');
})->middleware(['auth'])->name('food.scan');

Route::get('/tanya-ai', function () {
    return view('ai-chat');
})->middleware(['auth'])->name('ai.chat');


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::resource('children', ChildController::class);

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