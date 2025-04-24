<?php
// app/Policies/ReceiptPolicy.php

namespace App\Policies;

use App\Models\Receipt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReceiptPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $authUser): bool
    {
        return true;
    }

    public function view(User $authUser, Receipt $receipt): bool
    {
        return true;
    }

    public function create(User $authUser): bool
    {
        return true;
    }

    public function update(User $authUser, Receipt $receipt): bool
    {
        return true;
    }

    /**
     * Запрещаем удаление любых Receipt
     */
    public function delete(User $authUser, Receipt $receipt): bool
    {
        return false;
    }

    public function restore(User $authUser, Receipt $receipt): bool
    {
        return false;
    }

    public function forceDelete(User $authUser, Receipt $receipt): bool
    {
        return false;
    }
}
