<?php

namespace App\Http\Permissions;

use App\Models\User;

class Abilities
{
    public const CREATE_MOVEMENTS = 'create:movements';
    public const DELETE_MOVEMENTS = 'delete:movements';
    public const DELETE_OWN_MOVEMENTS = 'delete:own:movements';

    public static function for(User $user)
    {
        if ($user->isAdmin()) {
            return [
                self::CREATE_MOVEMENTS,
                self::DELETE_MOVEMENTS,
                self::DELETE_OWN_MOVEMENTS,
            ];
        }

        return [
            self::CREATE_MOVEMENTS,
            self::DELETE_OWN_MOVEMENTS,
        ];
    }
}
