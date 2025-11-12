<?php

namespace App\Services;

use Illuminate\Container\Attributes\Bind;

// Binding tramite properties
//#[Bind(GithubUserService::class)]
//#[Bind(DummyService::class, environments: ['local', 'testing'])]
interface UserServiceInterface
{
    public function getUser(string $username);
}
