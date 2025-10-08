@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">Create Product</h1>
            <p class="text-muted">Add a new product to your catalog.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" class="needs-validation" novalidate>
                @include('products._form', ['submitLabel' => 'Save', 'product' => null])
            </form>
        </div>
    </div>
@endsection
