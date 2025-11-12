<?php

namespace App\Services;

class CachedGithubUserService implements UserServiceInterface
{
    public function __construct(protected GithubUserService $githubUserService, protected int $ttl)
    {

    }

    public function getUser(string $username)
    {
        return cache()->remember('github:user:' . $username, $this->ttl,
            fn() => $this->githubUserService->getUser($username));
    }
}
