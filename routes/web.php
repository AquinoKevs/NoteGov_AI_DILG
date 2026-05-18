<?php

use App\Http\Controllers\AdminAnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotebookChatController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard')->name('home');

Route::get('/dashboard', DashboardController::class)->name('dashboard');
Route::get('/analytics', AdminAnalyticsController::class)->name('analytics');

Route::resource('notebooks', NotebookController::class);

Route::post('/notebooks/{notebook}/sources', [SourceController::class, 'store'])
    ->middleware('throttle:uploads')
    ->name('notebooks.sources.store');
Route::delete('/notebooks/{notebook}/sources/{source}', [SourceController::class, 'destroy'])
    ->name('notebooks.sources.destroy');

Route::get('/notebooks/{notebook}/chats/{chat}/export', [NotebookChatController::class, 'export'])
    ->name('notebooks.chats.export');

Route::post('/notebooks/{notebook}/members', [\App\Http\Controllers\NotebookMemberController::class, 'store'])
    ->name('notebooks.members.store');
Route::delete('/notebooks/{notebook}/members/{member}', [\App\Http\Controllers\NotebookMemberController::class, 'destroy'])
    ->name('notebooks.members.destroy');
