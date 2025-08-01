<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserFromTg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/webhook', TelegramController::class);
Route::middleware(EnsureUserFromTg::class)->controller(UserController::class)->group(function () {
    Route::get('/user', 'show');
    Route::post('/user', 'update');
});
Route::middleware(EnsureUserFromTg::class)->controller(LeaderboardController::class)->group(function () {
    Route::get('/leaderboard', 'index');
});
Route::middleware(EnsureUserFromTg::class)
    ->controller(ReceiptController::class)
    ->group(function () {
        Route::post('/receipts', 'store');
        Route::get('/receipts/history', 'history');
        Route::get('/receipts/history/restaurant', 'historyByRestaurant');
    });
Route::middleware(EnsureUserFromTg::class)
    ->controller(ReviewController::class)
    ->group(function () {
        Route::post('/reviews', 'store');
    });
Route::middleware(EnsureUserFromTg::class)
    ->controller(RestaurantController::class)
    ->group(function () {
        Route::get('/restaurants/search', 'search');
    });
Route::middleware(EnsureUserFromTg::class)
    ->controller(OfferController::class)
    ->group(function () {
        Route::get('/offers/index', 'index');
        Route::get('/offers/{offer}', 'show');
        Route::post('/offers/{offer}/purchase', 'purchase');
    });
Route::middleware(EnsureUserFromTg::class)
    ->controller(NotificationController::class)
    ->group(function () {
        Route::get('/notifications/index', 'index');
        Route::get('/notifications/unread-count', 'unreadCount');
        Route::post('/notifications/{notification}/read', 'markRead');
    });
Route::middleware(EnsureUserFromTg::class)
    ->controller(TutorialController::class)
    ->group(function () {
        Route::get('/tutorial/status', 'status');
        Route::post('/tutorial/complete', 'complete');
        Route::post('/tutorial/skip', 'skipTutorial');
    });
