<?php

namespace App\Policies;

use App\Models\User;

class RestrictedPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, $ability): ?bool
    {
        if ($user->roles()->where('nama_role', 'Admin')->exists()) {
            return true;
        }

        return null; // Fall through to specific methods
    }

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, $model): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, $model): bool
    {
        return false;
    }

    public function delete(User $user, $model): bool
    {
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function forceDelete(User $user, $model): bool
    {
        return false;
    }

    public function forceDeleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, $model): bool
    {
        return false;
    }

    public function restoreAny(User $user): bool
    {
        return false;
    }

    public function replicate(User $user, $model): bool
    {
        return false;
    }

    public function reorder(User $user): bool
    {
        return false;
    }
}
