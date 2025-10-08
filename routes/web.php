<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/products')->name('dashboard');

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');

Route::prefix('/products')->name('products.')->middleware('auth')->group(function () {
    Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\ProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [\App\Http\Controllers\ProductController::class, 'edit'])->name('edit')->middleware('can:edit-product,product');
    Route::match(['patch', 'put'], '/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('update')->middleware('can:edit-product,product');
    Route::delete('/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';
