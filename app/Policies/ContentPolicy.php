<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Aturan dasar untuk seluruh modul konten (Seniman, Karya, Kegiatan, Galeri).
 * Super Admin & Admin aktif boleh mengelola konten.
 */
abstract class ContentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageContent();
    }

    public function view(User $user, Model $model): bool
    {
        return $user->canManageContent();
    }

    public function create(User $user): bool
    {
        return $user->canManageContent();
    }

    public function update(User $user, Model $model): bool
    {
        return $user->canManageContent();
    }

    public function delete(User $user, Model $model): bool
    {
        return $user->canManageContent();
    }

    public function deleteAny(User $user): bool
    {
        return $user->canManageContent();
    }
}
