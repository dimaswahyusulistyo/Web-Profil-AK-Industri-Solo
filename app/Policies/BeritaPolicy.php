<?php

namespace App\Policies;

use App\Models\User;

class BeritaPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, $ability): ?bool
    {
        if ($user->roles()->where('nama_role', 'Admin')->exists()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->roles()->where('nama_role', 'Admin Berita')->exists();
    }

    public function view(User $user, $model): bool
    {
        return $user->roles()->where('nama_role', 'Admin Berita')->exists();
    }

    public function create(User $user): bool
    {
        return $user->roles()->where('nama_role', 'Admin Berita')->exists();
    }

    public function update(User $user, $model): bool
    {
        return $user->roles()->where('nama_role', 'Admin Berita')->exists();
    }

    public function delete(User $user, $model): bool
    {
        return $user->roles()->where('nama_role', 'Admin Berita')->exists();
    }

    public function deleteAny(User $user): bool
    {
        return $user->roles()->where('nama_role', 'Admin Berita')->exists();
    }
}
