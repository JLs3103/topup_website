<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\OrderVerificationController;
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
    Route::get('account', [AccountController::class, 'index'])
        ->name('account.index');

    Route::get('help', [AccountController::class, 'faq'])
        ->name('faq.index');

    Route::post('notifications/read-all', [AccountController::class, 'markNotificationsRead'])
        ->name('notifications.read-all');

    Route::get('games/{slug}', [TopupController::class, 'show'])
        ->name('games.show');

    Route::post('games/{slug}/order', [TopupController::class, 'store'])
        ->name('games.order.store');

    Route::get('orders', [TopupController::class, 'orderHistory'])
        ->name('orders.index');

    Route::get('orders/{order}', [TopupController::class, 'showOrder'])
        ->name('orders.show');

    Route::post('orders/{order}/pay', [TopupController::class, 'submitPaymentProof'])
        ->name('orders.pay');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('orders', [OrderVerificationController::class, 'index'])
        ->name('orders.index');

    Route::get('orders/{order}', [OrderVerificationController::class, 'show'])
        ->name('orders.show');

    Route::patch('orders/{order}/status', [OrderVerificationController::class, 'updateStatus'])
        ->name('orders.update-status');

    Route::get('activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity-logs.index');

    Route::resource('faqs', FaqController::class)
        ->except(['show']);
});

require __DIR__.'/auth.php';
