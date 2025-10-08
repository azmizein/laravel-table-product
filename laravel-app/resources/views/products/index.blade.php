@php($title = 'Product Dashboard')
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">{{ $title }}</h1>
            <p class="text-muted">Manage your catalog, keep stock accurate, and import products from Fake Store.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
            <button id="sync-products" class="btn btn-outline-secondary" data-sync-url="{{ route('products.sync') }}">Sync Products</button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col" class="d-none d-md-table-cell">Updated</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td>${{ number_format((float) $product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td class="d-none d-md-table-cell">{{ optional($product->updated_at)->diffForHumans() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No products yet. Create one or sync from Fake Store.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($products->hasPages())
            <div class="card-footer">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
