<?php

use App\Http\Controllers\MovementController;
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

require __DIR__ . '/auth.php';
