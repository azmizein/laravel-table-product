@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">Edit Product</h1>
            <p class="text-muted">Update product information and inventory.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST" class="needs-validation" novalidate>
                @method('PUT')
                @include('products._form', ['submitLabel' => 'Update'])
            </form>
        </div>
    </div>
@endsection
