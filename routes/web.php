<?php

use App\Http\Controllers\ReferralController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/r/{token}', [ReferralController::class, 'redirect'])
    ->name('referral.redirect');
