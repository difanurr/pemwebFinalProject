<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\LoginController::class, 'show'])->name('login.show');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.login');
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/barang', [App\Http\Controllers\BarangController::class, 'show'])->name('barang.show');
    Route::post('/barang/add', [App\Http\Controllers\BarangController::class, 'add'])->name('barang.add');
    Route::post('/barang/update/{id}', [App\Http\Controllers\BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/delete/{id}', [App\Http\Controllers\BarangController::class, 'delete'])->name('barang.delete');

    Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer.show');
    Route::post('/customer/add', [App\Http\Controllers\CustomerController::class, 'add'])->name('customer.add');
    Route::post('/customer/update/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/delete/{id}', [App\Http\Controllers\CustomerController::class, 'delete'])->name('customer.delete');

    Route::get('/transaksi', [App\Http\Controllers\TransaksiController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi/add', [App\Http\Controllers\TransaksiController::class, 'add'])->name('transaksi.add');
    Route::post('/transaksi/update/{id}', [App\Http\Controllers\TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/delete/{id}', [App\Http\Controllers\TransaksiController::class, 'delete'])->name('transaksi.delete');

    Route::get('/detail', [App\Http\Controllers\DetailController::class, 'show'])->name('detail.show');
    Route::post('/detail/add', [App\Http\Controllers\DetailController::class, 'add'])->name('detail.add');
    Route::post('/detail/update/{id}', [App\Http\Controllers\DetailController::class, 'update'])->name('detail.update');
    Route::delete('/detail/delete/{id}', [App\Http\Controllers\DetailController::class, 'delete'])->name('detail.delete');
});