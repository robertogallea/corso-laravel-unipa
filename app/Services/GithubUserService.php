<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubUserService implements UserServiceInterface
{
    public function getUser(string $username)
    {
        return Http::asJson()->get('https://api.github.com/users/' . $username)->json();
    }
}
