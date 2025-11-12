<?php

namespace App\Facades;

use App\Services\UserServiceInterface;
use Illuminate\Support\Facades\Facade;

class Github extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return UserServiceInterface::class;
    }
}
