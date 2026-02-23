<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BillingController;

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});
Route::resource('contacts', ContactController::class)->middleware('subscribed');
Route::middleware(['auth'])->group(function () {

    Route::get('/planes', [PlanController::class, 'index'])->name('plans.index');

    Route::middleware(['subscribed'])->group(function () {
        Route::resource('campaigns', CampaignController::class);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    });

    Route::middleware('auth')->group(function () {

        Route::post('/subscribe/{plan}', [SubscriptionController::class, 'store'])
            ->name('subscribe');
        Route::get('/redirect-after-login', function () {

            if (!auth()->user()->hasActiveSubscription()) {
                return redirect()->route('plans.index');
            }

            return redirect()->route('dashboard');
        })->middleware('auth');
    });
});
Route::middleware(['auth', 'subscribed'])->group(function () {

    Route::view('/contacts', 'contacts.index')->name('contacts.index');
    Route::view('/campaigns', 'campaigns.index')->name('campaigns.index');
    Route::view('/media', 'media.index')->name('media.index');
});
Route::middleware(['auth'])->group(function () {

    Route::post('/subscribe/{plan}', [SubscriptionController::class, 'store'])
        ->name('subscribe');

    Route::get('/checkout/{plan}', [SubscriptionController::class, 'checkout'])
        ->name('checkout');

    Route::post('/payment/process/{plan}', [SubscriptionController::class, 'processPayment'])
        ->name('payment.process');

    Route::get('/subscription/show', [SubscriptionController::class, 'show'])
        ->name('subscription.show');
});
Route::middleware('auth')->group(function(){


    Route::resource('contacts', ContactController::class)->only(['index','store']);

    Route::get('campaigns/create',[CampaignController::class,'create'])->name('campaigns.create');
    Route::post('campaigns',[CampaignController::class,'store'])->name('campaigns.store');

    Route::get('billing',[BillingController::class,'index'])->name('billing.index');
    Route::post('billing/refund/{id}',[BillingController::class,'refund'])->name('billing.refund');

});
require __DIR__ . '/auth.php';
