<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote');

\Illuminate\Support\Facades\Schedule::command('app:process-products')
    ->hourly()->days([Schedule::MONDAY, Schedule::FRIDAY]); // su base oraria solo lunedì e venerdì

\Illuminate\Support\Facades\Schedule::command('app:process-products')
    ->hourly()->between('09:00', '14:00'); // su base oraria ma solo fra le 09.00 e le 14.00

\Illuminate\Support\Facades\Schedule::command('app:process-products')
    ->daily()->when(function () { // ->unless()
        return rand(0, 20) > 5;
    }); // schedulazione condizionale

\Illuminate\Support\Facades\Schedule::exec('git pull') // schedulazione di un comando di sistema
->everyFifteenMinutes();

\Illuminate\Support\Facades\Schedule::exec('composer update') // schedulazione solo su ambiente specifici
->daily()
    ->environments(['staging', 'local']);

\Illuminate\Support\Facades\Schedule::command('app:process-products')
    ->hourly()->withoutOverlapping(); // schedulazione senza sovrapposizioni

\Illuminate\Support\Facades\Schedule::exec('composer update')
    ->daily()
    ->environments(['staging', 'local'])
    ->runInBackground();  // esecuzione del comando in background

\Illuminate\Support\Facades\Schedule::exec('php artisan migrate --force')
    ->hourly()
    ->onOneServer(); // esecuzione su singola istanza (usando lock in cache)

\Illuminate\Support\Facades\Schedule::everyThirtyMinutes()
    ->when(now()->greaterThan(\Carbon\Carbon::parse('2026-01-01 00:00:00')))
    ->group(function () {
        \Illuminate\Support\Facades\Schedule::command('app:process-products');
        \Illuminate\Support\Facades\Schedule::command('app:other-command');
    }); // gruppi di comandi schedulati con le stesse impostazioni

\Illuminate\Support\Facades\Schedule::command('app:other-command')
    ->everyFiveSeconds();


\Illuminate\Support\Facades\Schedule::command('app:other-command')
    ->everyOddHour()
    ->sendOutputTo('output.txt'); // (sovra)scrive un file con l'output del command
//->appendOutputTo('output.txt'); // aggiunge al contenuto di un file l'output del command
//->emailOutputTo($email); // invia l'output di un comando per email
//->emailOutputOnFailure($email); // invia l'output di un comando *che fallisce* per email


\Illuminate\Support\Facades\Schedule::command('app:other-command')
    ->before(function () {
        // callback da eseguire prima dell'esecuzione
    })
    ->after(function () {
        // callback da eseguire dopo l'esecuzione
    })
    ->onSuccess(function () {
        // callback da eseguire se l'esecuzione ha successo
    })
    ->onFailure(function () {
        // callback da eseguire se l'esecuzione fallisce
    });
