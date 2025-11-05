<?php

namespace App\Policies;

use App\Http\Permissions\Abilities;
use App\Models\Movement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MovementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Movement $movement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan(Abilities::CREATE_MOVEMENTS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Movement $movement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Movement $movement): bool
    {
        if ($user->tokenCan(Abilities::DELETE_MOVEMENTS)) {
            return true;
        }

        if ($user->tokenCan(Abilities::DELETE_OWN_MOVEMENTS) &&
            ($movement->user_id == $user->id)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Movement $movement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Movement $movement): bool
    {
        return false;
    }
}
