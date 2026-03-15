<?php

use App\Http\Controllers\TopupController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function (): void {
    Route::get('games/{slug}', [TopupController::class, 'show'])
        ->name('games.show');

    Route::post('games/{slug}/order', [TopupController::class, 'store'])
        ->name('games.order.store');

    Route::get('orders', [TopupController::class, 'orderHistory'])
        ->name('orders.index');
});

require __DIR__.'/auth.php';
