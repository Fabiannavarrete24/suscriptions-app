<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\messageController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Planes
    Route::get('/planes', [PlanController::class, 'index'])
        ->name('plans.index');

    // Suscripciones
    Route::post('/subscribe/{plan}', [SubscriptionController::class, 'store'])
        ->name('subscribe');

    Route::get('/checkout/{plan}', [SubscriptionController::class, 'checkout'])
        ->name('checkout');

    Route::post('/payment/process/{plan}', [SubscriptionController::class, 'processPayment'])
        ->name('payment.process');

    Route::get('/subscription/show', [SubscriptionController::class, 'show'])
        ->name('subscription.show');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Solo usuarios suscritos
    Route::middleware(['subscribed'])->group(function () {

        Route::resource('contacts', ContactController::class)
            ->only(['index', 'store', 'destroy']);

        Route::resource('messages', MessageController::class)
            ->only(['index', 'store','create']);

        Route::get('billing', [BillingController::class, 'index'])
            ->name('billing.index');

        Route::post('billing/refund/{id}', [BillingController::class, 'refund'])
            ->name('billing.refund');
    });
});

require __DIR__ . '/auth.php';