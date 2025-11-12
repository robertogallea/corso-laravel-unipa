<?php

namespace App\Services;

class RandomService
{
    private int $value;

    public function __construct()
    {
        $this->value = rand(1, 1000);
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
