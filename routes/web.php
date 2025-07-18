<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CSKtaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tasks.index'); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task Management Routes (specific routes first)
    Route::get('/tasks/completed', [CSKtaskController::class, 'completed'])->name('tasks.completed');
    Route::resource('tasks', CSKtaskController::class);
});

Route::post('/tasks/{task}/remind', [CSKtaskController::class, 'sendReminder'])
    ->name('tasks.send-reminder')
    ->middleware('auth');

require __DIR__.'/auth.php';