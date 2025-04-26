<?php

namespace App\Policies;

use App\Models\Clients\RankAttribute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RankAttributesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return true;
    }

    public function view(User $authUser, RankAttribute $rankAttribute): bool
    {
        return true;
    }

    public function create(User $authUser): bool
    {
        return true;
    }

    public function update(User $authUser, RankAttribute $rankAttribute): bool
    {
        return true;
    }

    /**
     * Запрещаем удаление любых Receipt
     */
    public function delete(User $authUser, RankAttribute $rankAttribute): bool
    {
        return true;
    }

    public function restore(User $authUser, RankAttribute $rankAttribute): bool
    {
        return true;
    }

    public function forceDelete(User $authUser, RankAttribute $rankAttribute): bool
    {
        return false;
    }
}
