<?php

declare(strict_types=1);

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('products.index'));

Route::resource('products', ProductController::class)->except(['show']);
Route::post('products/sync', [ProductController::class, 'sync'])->name('products.sync');
