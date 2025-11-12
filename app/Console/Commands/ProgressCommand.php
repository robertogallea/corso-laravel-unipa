<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProgressCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:progress-command';

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
        $max = 100;
        $bar = $this->output->createProgressBar($max);

        $bar->start();

        foreach (range(1, $max) as $i) {
            usleep(100_000);
            $bar->advance();
        }

        $bar->finish();
    }
}
