<?php

namespace App\Console\Commands;

use App\Services\UserServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class TestCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command {user} {--some-option=*}';
    // {argument}
    // {optionalArgument?}
    // {--option} presente o non presente
    // {--option=} con valore
    // {--option=*} con valore multiplo

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UserServiceInterface $service)
    {
        $this->info($service->getUser($this->argument('user'))['avatar_url']);
        foreach ($this->option('some-option') as $optionValue) {
            $this->warn($optionValue);
        }
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'user' => 'Qual è l\'utente per cui vuoi le informazioni',
        ];
    }
}
