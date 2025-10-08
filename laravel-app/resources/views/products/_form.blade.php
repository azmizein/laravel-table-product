@csrf
<div class="mb-3">
    <label class="form-label" for="name">Name</label>
    <input id="name" type="text" name="name" class="form-control" value="{{ old('name', optional($product)->name) }}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="price">Price</label>
    <input id="price" type="number" step="0.01" name="price" class="form-control" value="{{ old('price', optional($product)->price) }}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="stock">Stock</label>
    <input id="stock" type="number" name="stock" class="form-control" value="{{ old('stock', optional($product)->stock) }}" required>
</div>
<div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', optional($product)->description) }}</textarea>
</div>
<button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
<a href="{{ route('products.index') }}" class="btn btn-link">Cancel</a>
