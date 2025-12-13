<?php


use App\Http\Controllers\DashboardController;


use App\Http\Controllers\IncidentController;
use App\Http\Controllers\UserProfileController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


/* page redirect view */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');




/* User navbar menu */
//create incident
Route::prefix('user')->name('user.')->group(function () {
    Route::get('ticket/incident', [IncidentController::class, 'create'])->name('ticket.incident.create');
    Route::post('ticket/incident', [IncidentController::class, 'store'])->name('ticket.incident.store');
});
//user profile
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function() {
    Route::get('profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('profile', [UserProfileController::class, 'update'])->name('profile.update');
});



/* laravel default build */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
