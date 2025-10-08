<?php

declare(strict_types=1);

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/products', function () {
    return ProductResource::collection(Product::orderBy('name')->paginate(10));
});
