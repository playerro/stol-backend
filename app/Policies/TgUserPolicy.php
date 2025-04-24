<?php
// app/Policies/TgUserPolicy.php

namespace App\Policies;

use App\Models\Clients\TgUser;
use App\Models\User; // или вашу модель пользователя-администратора
use Illuminate\Auth\Access\HandlesAuthorization;

class TgUserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return true;
    }

    public function view(User $authUser, TgUser $tgUser): bool
    {
        return true;
    }

    public function create(User $authUser): bool
    {
        return true;
    }

    public function update(User $authUser, TgUser $tgUser): bool
    {
        return true;
    }

    /**
     * Запрещаем удаление любых TgUser
     */
    public function delete(User $authUser, TgUser $tgUser): bool
    {
        return false;
    }

    public function restore(User $authUser, TgUser $tgUser): bool
    {
        return false;
    }

    public function forceDelete(User $authUser, TgUser $tgUser): bool
    {
        return false;
    }
}
