<?php

use App\Http\Controllers\Front;
use Illuminate\Support\Facades\Route;

Route::stripeWebhooks('/ipn/stripe')->name('ipn.stripe');

Route::post('/ipn/paypal', [Front\IpnController::class, 'paypal'])->name('ipn.paypal');
