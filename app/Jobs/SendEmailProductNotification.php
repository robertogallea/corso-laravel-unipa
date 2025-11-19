<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendEmailProductNotification implements ShouldQueue
{
    use Queueable;
    use Batchable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $userId, public int $productId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $product = Product::find($this->productId);
        $users = User::whereIn('id', $this->userId)->get();

        $users->each(function ($user) use ($product) {
            \Mail::to($user)->send(new \App\Mail\MarkdownNewProductEmail($product));
        });
    }
}
