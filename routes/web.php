<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\DashboardController;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! | */

Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::get('dashboard/products/create', [ProductController::class , 'create'])->name('dashboard.products.create');
Route::get('dashboard/products', [ProductController::class , 'index'])->name('dashboard.products.index');
Route::get('dashboard/products/{id}/edit', [ProductController::class , 'edit'])->name('dashboard.products.edit');
Route::post('dashboard/products/store', [ProductController::class , 'store'])->name('dashboard.products.store');
Route::put('dashboard/products/{id}/update', [ProductController::class , 'update'])->name('dashboard.products.update');
Route::DELETE('dashboard/products/{id}/destroy', [ProductController::class , 'destroy'])->name('dashboard.products.destroy');
Route::patch('dashboard/products/toggle/status/{id}', [ProductController::class , 'toggleStatus'])->name('dashboard.products.toggle.status');