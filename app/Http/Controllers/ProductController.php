<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\FakeStoreClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::orderByDesc('created_at')->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('status', 'Product deleted successfully.');
    }

    public function sync(Request $request, FakeStoreClient $client): RedirectResponse|JsonResponse
    {
        $limit = (int) $request->input('limit', 5);
        $limit = max(1, min($limit, 20));

        $imported = $client->fetchProducts($limit)->map(function (array $attributes): Product {
            return Product::updateOrCreate(
                ['name' => $attributes['name']],
                $attributes
            );
        });

        if ($request->expectsJson()) {
            $products = Product::whereIn('id', $imported->pluck('id'))->get();

            return ProductResource::collection($products)
                ->additional(['message' => 'Products synced successfully.'])
                ->response();
        }

        return redirect()->route('products.index')->with('status', sprintf('%d products synced successfully.', $imported->count()));
    }
}
