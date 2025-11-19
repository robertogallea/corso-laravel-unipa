<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UniqueJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $dbName)
    {
        //
    }

    public function uniqueId()
    {
        return $this->dbName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
