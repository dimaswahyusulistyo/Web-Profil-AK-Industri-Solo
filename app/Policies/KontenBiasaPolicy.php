<?php

namespace App\Policies;

use App\Models\KontenBiasa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KontenBiasaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all
        if ($user->roles()->where('nama_role', 'Admin')->exists()) {
            return true;
        }

        // Arsiparis can view (will be filtered in Resource)
        if ($user->roles()->where('nama_role', 'Arsiparis')->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KontenBiasa $kontenBiasa): bool
    {
        // Admin can view all
        if ($user->roles()->where('nama_role', 'Admin')->exists()) {
            return true;
        }

        // Arsiparis can only view 'pusat-informasi'
        if ($user->roles()->where('nama_role', 'Arsiparis')->exists()) {
            return $kontenBiasa->url_halaman === 'pusat-informasi';
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin can create
        return $user->roles()->where('nama_role', 'Admin')->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KontenBiasa $kontenBiasa): bool
    {
        // Admin can update all
        if ($user->roles()->where('nama_role', 'Admin')->exists()) {
            return true;
        }

        // Arsiparis can only update 'pusat-informasi'
        if ($user->roles()->where('nama_role', 'Arsiparis')->exists()) {
            return $kontenBiasa->url_halaman === 'pusat-informasi';
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KontenBiasa $kontenBiasa): bool
    {
        // Only Admin can delete
        return $user->roles()->where('nama_role', 'Admin')->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KontenBiasa $kontenBiasa): bool
    {
        // Only Admin can restore
        return $user->roles()->where('nama_role', 'Admin')->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KontenBiasa $kontenBiasa): bool
    {
        // Only Admin can force delete
        return $user->roles()->where('nama_role', 'Admin')->exists();
    }
}
