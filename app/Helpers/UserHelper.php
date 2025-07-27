<?php

namespace App\Helpers;

use App\Models\Clients\TgUser;

class UserHelper
{

    public static function getDisplayName(TgUser $user): string
    {
        return $user->app_username
            ?? $user->username
            ?? (string) $user->telegram_id;
    }
}
