<?php

namespace App\Policies;

use App\Models\Menage;
use App\Models\User;

class MenagePolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Menage $menage): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isDirector()
            || $user->isCommecial();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Menage $menage): bool
    {
        return $user->isDirector()
            || $user->isCommecial();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Menage $menage): bool
    {
        return $user->isDirector();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Menage $menage): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Menage $menage): bool
    {
        return false;
    }
}
