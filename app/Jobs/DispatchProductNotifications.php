<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class DispatchProductNotifications implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobs = [];
        $chunk = 3;

        User::query()->chunk($chunk, function ($users) use (&$jobs) {
            $jobs[] = new SendEmailProductNotification(
                $users->pluck('id')->all(),
                $this->product->id
            );
        });
        $productName = $this->product->name;
        Bus::batch($jobs)
            ->name('Notifiche per il prodotto ' . $productName)
            ->then(fn() => Log::info('Notifiche completate per il prodotto ' . $productName))
            ->dispatch();
    }
}
