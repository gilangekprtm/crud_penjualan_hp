<?php

use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('product.index');
});

//product
Route::get('/product', [ProductController::class, 'index'])->name('product.index');

//penjualan
Route::get('/penjualan/{sales_id}/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::get('/product/{product_id}', [ProductController::class, 'getPriceById'])->name('product.getPriceById');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');

Route::put('/penjualan/{sales_id}', [PenjualanController::class, 'update'])->name('penjualan.update');
Route::delete('/penjualan/{sales_id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');

