<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChildController;
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

require __DIR__.'/auth.php';