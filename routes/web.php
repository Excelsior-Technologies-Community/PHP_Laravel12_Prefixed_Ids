<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return redirect('/orders');
});

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');