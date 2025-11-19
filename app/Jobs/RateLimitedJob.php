<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class RateLimitedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info(now()->format('Y-m-d H:i:s'));
    }

    public function middleware()
    {
        return [
            new RateLimited('api-job'),
//            new WithoutOverlapping('processing-catalog')
//        new ThrottlesExceptions(10, 60 * 10)
//            Skip::when(fn () => $condition) // il job viene saltato se la condizione è falsa
        ];
    }
}
