
<?php

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodScanController;
use App\Http\Controllers\GrowthRecordController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\Doctor\DoctorConsultationController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorPatientsController;
use App\Http\Controllers\Doctor\DoctorProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/nutrition', [NutritionController::class, 'index'])->name('nutrition');
    Route::post('/nutrition/meals', [NutritionController::class, 'store'])->name('nutrition.meals.store');
    Route::put('/nutrition/meals/{meal}', [NutritionController::class, 'update'])->name('nutrition.meals.update');
    Route::delete('/nutrition/meals/{meal}', [NutritionController::class, 'destroy'])->name('nutrition.meals.destroy');

    // Route nested /children/{child}/meals untuk keselarasan kontrak desain
    Route::post('/children/{child}/meals', [NutritionController::class, 'storeForChild'])->name('children.meals.store');
    Route::put('/children/{child}/meals/{meal}', [NutritionController::class, 'updateForChild'])->name('children.meals.update');
    Route::delete('/children/{child}/meals/{meal}', [NutritionController::class, 'destroyForChild'])->name('children.meals.destroy');

    Route::get('/food-scan', [FoodScanController::class, 'index'])->name('food.scan');
    Route::prefix('food-scan')->name('food.scan.')->group(function () {
        Route::post('/', [FoodScanController::class, 'store'])
            ->middleware('throttle:15,1')
            ->name('store');
        Route::get('/{analysis}', [FoodScanController::class, 'show'])->name('show');
        Route::get('/{analysis}/status', [FoodScanController::class, 'status'])->name('status');
        Route::get('/{analysis}/image', [FoodScanController::class, 'image'])->name('image');
        Route::post('/{analysis}/confirm', [FoodScanController::class, 'confirm'])->name('confirm');
        Route::delete('/{analysis}', [FoodScanController::class, 'destroy'])->name('destroy');
    });

    Route::get('/tanya-ai', [AiChatController::class, 'index'])->name('ai.chat');
    Route::post('/tanya-ai', [AiChatController::class, 'send'])
        ->middleware('throttle:15,1')
        ->name('ai.chat.send');
    Route::delete('/tanya-ai', [AiChatController::class, 'clear'])
        ->name('ai.chat.clear');

    Route::resource('children', ChildController::class);
    Route::resource('children.growth-records', GrowthRecordController::class)
        ->parameters(['growth-records' => 'record']);

    // Konsultasi Dokter dari Sisi Orang Tua
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::post('/consultations/{consultation}/messages', [ConsultationController::class, 'sendMessage'])->name('consultations.messages.store');
    Route::post('/consultations/{consultation}/cancel', [ConsultationController::class, 'cancel'])->name('consultations.cancel');
    Route::delete('/consultations/{consultation}', [ConsultationController::class, 'cancel'])->name('consultations.destroy');
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

        Route::post('/konsultasi/{id}/message', [DoctorConsultationController::class, 'sendMessage'])
            ->name('konsultasi.message');

        Route::post('/konsultasi/{id}/accept', [DoctorConsultationController::class, 'accept'])
            ->name('konsultasi.accept');

        Route::post('/konsultasi/{id}/notes', [DoctorConsultationController::class, 'saveNotes'])
            ->name('konsultasi.notes');

        Route::post('/konsultasi/{id}/complete', [DoctorConsultationController::class, 'complete'])
            ->name('konsultasi.complete');

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

    // Alias logout dokter untuk kompatibilitas, memakai controller autentikasi yang sama
    Route::post('/dokter/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('dokter.logout');

    // Notifikasi Sistem (Shared antara Parent dan Dokter)
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
        ->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
        ->name('notifications.read-all');
});

/*
|--------------------------------------------------------------------------
| LEGACY DOCTOR AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/dokter/login', function () {
        return redirect()->route('login');
    })->name('dokter.login');

    Route::post('/dokter/login', [AuthenticatedSessionController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
