<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ProgressLogController;
use App\Http\Controllers\ShareController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Objectifs
    Route::resource('goals', GoalController::class);

    // Milestones
    Route::post('goals/{goal}/milestones', [MilestoneController::class, 'store'])->name('milestones.store');
    Route::patch('goals/{goal}/milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');
    Route::delete('goals/{goal}/milestones/{milestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');

    // Progress Logs
    Route::post('goals/{goal}/progress', [ProgressLogController::class, 'store'])->name('progress.store');

    // Habitudes
    Route::get('habits-history', [App\Http\Controllers\HabitController::class, 'history'])->name('habits.history');
    Route::resource('habits', App\Http\Controllers\HabitController::class);
    Route::post('habits/{habit}/toggle', [App\Http\Controllers\HabitLogController::class, 'toggle'])->name('habits.toggle');
});

Route::get('/share/{goal}', [ShareController::class, 'show'])->name('share.show');

require __DIR__.'/auth.php';
