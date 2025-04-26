<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class ReferralController extends Controller
{
    /**
     * Принимает короткий токен, ищет пользователя
     * и редиректит на телеграм-бота с нужным start-параметром.
     */
    public function redirect(string $token)
    {
        $user = User::where('referral_token', $token)->firstOrFail();
        $botUsername = config('app.telegram.bot_username');

        $url = "https://t.me/{$botUsername}?start={$user->referral_token}";

        return redirect()->away($url);
    }
}
