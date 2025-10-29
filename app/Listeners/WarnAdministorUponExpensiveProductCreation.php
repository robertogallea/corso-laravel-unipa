<?php

namespace App\Listeners;

use App\Events\CheapProductCreated;
use App\Events\ExpensiveProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WarnAdministorUponExpensiveProductCreation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ExpensiveProductCreated|CheapProductCreated $event): void
    {
        dump($event->product);
    }
}
