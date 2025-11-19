<?php

use App\Http\Controllers\MovementController;
use App\Mail\TestMail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/products')->name('dashboard');


Route::prefix('/products')->name('products.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('index')->withoutMiddleware('auth')->middleware('can:index,App\Models\Product');
    Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('create')->middleware('can:create,App\Models\Product');
    Route::post('/', [\App\Http\Controllers\ProductController::class, 'store'])->name('store')->middleware('can:create,App\Models\Product');
    Route::get('/{product}/edit', [\App\Http\Controllers\ProductController::class, 'edit'])->name('edit')->middleware('can:edit,product');
    Route::match(['patch', 'put'], '/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('update')->middleware('can:edit,product');
    Route::delete('/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy')->middleware('can:delete,product');
});

Route::get('/movements', [MovementController::class, 'index'])->name('movements.index');

Route::get('/middleware', fn(Request $request) => dd($request))->middleware('set-attribute:my-attribute,my-value');


Route::get('/test-gate/{product}', function (Product $product) {
    dump($product->price);

    // inspect fornisce come risposta la response completa
//    $response = \Illuminate\Support\Facades\Gate::inspect('edit-product', $product);
//    dd($response->allowed(), $response->status(), $response->message());

    if (\Illuminate\Support\Facades\Gate::allows('edit', $product)) {
        dd('azione consentita');
    } else {
        dd('azione non consentita');
    }


//    \Illuminate\Support\Facades\Gate::denies('edit-product', $product); // duale di allows

//    \Illuminate\Support\Facades\Gate::any(['edit-product', 'test'], $product); // tutte le abilità soddisfatte

//    \Illuminate\Support\Facades\Gate::none(['ability1', 'ability2']); // nessuna delle abilità sia soddisfatta

    // controllare l'abilità per un utente generico (invece che quello correntemente loggato)
//    \Illuminate\Support\Facades\Gate::forUser(\App\Models\User::first())->allows('edit-product', $product);
});


Route::get('/relations', function () {
    // lazy loading (N+1 problem)
    $users = \App\Models\User::all();

    // eager loading
//    $users = \App\Models\User::with('movements', 'movements.products')->get();

    // eager lazy loading
//   $users->load('movements', 'movements.product');

    foreach ($users as $user) {
        dump($user->movements);
        foreach ($user->movements as $movement) {
            dump($movement->products);
        }
    }
});

Route::get('/relations-count', function () {

    // precarico in movements_count il numero di movements di ciascun user
    $users = \App\Models\User::withCount('movements')->get();

    foreach ($users as $user) {
        dump($user->movements_count);
    }
});

Route::get('/relations-sum', function () {

    // precarico in movements_count il numero di movements di ciascun user
    $users = \App\Models\User::withSum('movements', 'user_id')
        ->withMax('movements', 'user_id')
        ->withAvg('movements', 'user_id')
        ->get();

    foreach ($users as $user) {
        dump(
            $user->movements_sum_user_id,
            $user->movements_max_user_id,
            $user->movements_avg_user_id
        );
    }
});

Route::get('/chunks', function () {
    \App\Models\Product::chunk(1000, function ($products, $i) {
        dump($products->count());
        dump("Blocco $i");
    });
});


Route::get('test-cache', function () {

//    if (cache()->has('test-cache')) {
//        return cache()->get('test-cache');
//    }
//
//    return cache()->set('test-cache', rand(1, 100), 15);

    // equivalente a

    return cache()->remember('test-cache', 15, fn() => rand(1, 100));
//   return cache()->rememberForever('test-cache', fn() => rand(1, 100));  // scadenza infinita
});


Route::get('/flex-cache', function () {
    $start = microtime(true);
//    $result = cache()->remember('not-flex-cache', 15, function () {
//        return Http::asJson()->get('https://api.github.com/users/laravel')->json();
//    });
    $result = cache()->flexible('flex-cache', [5, 15], function () {
        return Http::asJson()->get('https://api.github.com/users/laravel')->json();
    });
    $end = microtime(true);
    dump($end - $start);

    dump($result);

    // entro i 5 secondi il valore è valido e viene restituito
    // fra i 5+ secondi e 15 il valore è valido, viene restituito e la cache viene rinfrescata dietro le quinte
    // dopo i 15 secondi il valore non è valido, viene rinfrescata la cache e viene restituito il valore fresco
});

Route::get('/di', function (\App\Services\UserServiceInterface $service) {

//    app(\App\Services\UserServiceInterface::class)->getUser('laravel');
//    return \App\Facades\Github::getUser('laravel');

    return $service->getUser('laravel');
});


Route::get('/test-queue', function () {
   \App\Jobs\TestJob::dispatch('test');
//   \App\Jobs\TestJob::dispatchIf(function() {return rand(0,1); }, 'test'); // dispatch condizionale
//   \App\Jobs\TestJob::dispatchUnless(function() {return rand(0,1); }, 'test'); // dispatch condizionale duale
//    \App\Jobs\TestJob::dispatchSync('test'); // esecuzione sincrona
    \App\Jobs\TestJob::dispatch('test')->delay(30); // delay in numero di secondi
    \App\Jobs\TestJob::dispatch('test')->delay(now()->addDay()); // delay in numero di secondi
    \App\Jobs\EncryptedTestJob::dispatch('test')->delay(now()->addDay()); // delay in numero di secondi
});

Route::get('/test-unique', function () {
   \App\Jobs\UniqueJob::dispatch('testdb');
});


Route::get('/test-limited-job', function () {
   collect(range(1,50))->each(function ($i) {
       \App\Jobs\RateLimitedJob::dispatch();
   });
});


Route::get('/mail', function () {
   return new \App\Mail\MarkdownNewProductEmail(Product::first());
});

require __DIR__ . '/auth.php';

