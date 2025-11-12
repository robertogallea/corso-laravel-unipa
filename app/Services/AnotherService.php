<?php

namespace App\Services;

class AnotherService
{
    public function __construct(protected TestService $testService)
    {

    }

    public function call()
    {
        return $this->testService->testMe() . ' - it works';
    }
}
