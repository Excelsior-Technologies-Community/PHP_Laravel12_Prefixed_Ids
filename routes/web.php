<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrefixDashboardController;

Route::get('/', fn() => redirect('/orders'));

Route::get('/orders',                [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create',         [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders/store',         [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}',        [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{order}/edit',   [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}',        [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{order}',     [OrderController::class, 'destroy'])->name('orders.destroy');

// Prefix Dashboard
Route::get('/prefix-dashboard',                          [PrefixDashboardController::class, 'index'])->name('prefix.dashboard');
Route::post('/prefix-dashboard',                         [PrefixDashboardController::class, 'store'])->name('prefix.store');
Route::put('/prefix-dashboard/{prefixConfig}',           [PrefixDashboardController::class, 'update'])->name('prefix.update');
Route::delete('/prefix-dashboard/{prefixConfig}',        [PrefixDashboardController::class, 'destroy'])->name('prefix.destroy');
