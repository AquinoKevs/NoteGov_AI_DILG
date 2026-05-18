<?php

use App\Http\Controllers\AdminAnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotebookChatController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\NotebookMemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/analytics', AdminAnalyticsController::class)
        ->middleware('role:admin')
        ->name('analytics');

    Route::resource('notebooks', NotebookController::class);

    Route::post('/notebooks/{notebook}/sources', [SourceController::class, 'store'])
        ->middleware('throttle:uploads')
        ->name('notebooks.sources.store');
    Route::delete('/notebooks/{notebook}/sources/{source}', [SourceController::class, 'destroy'])
        ->name('notebooks.sources.destroy');

    Route::post('/notebooks/{notebook}/share', [NotebookMemberController::class, 'store'])
        ->name('notebooks.members.store');
    Route::delete('/notebooks/{notebook}/members/{member}', [NotebookMemberController::class, 'destroy'])
        ->name('notebooks.members.destroy');

    Route::get('/notebooks/{notebook}/chats/{chat}/export', [NotebookChatController::class, 'export'])
        ->name('notebooks.chats.export');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
