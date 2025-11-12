<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProcessProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->table(
            ['ID', 'Nome', 'Price'],
            Product::all(['id', 'name', 'price'])->toArray()
        );

        $this->withProgressBar(Product::all(), function (Product $product) {
            usleep(100_000);
            $this->info("Processing product {$product->id}");
        });

    }
}
