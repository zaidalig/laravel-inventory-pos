@extends('layouts.app')
@section('title', 'Add Product')
@section('page_title', 'Add Product')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form method="POST" action="{{ route('products.store') }}">@csrf
<div class="row g-3">
<div class="col-md-4"><label class="form-label">SKU</label><input name="sku" class="form-control" value="{{ old('sku') }}" required></div>
<div class="col-md-8"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name') }}" required></div>
<div class="col-md-6"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">None</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(old('category_id')==$cat->id)>{{ $cat->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Supplier</label><select name="supplier_id" class="form-select"><option value="">None</option>@foreach($suppliers as $s)<option value="{{ $s->id }}" @selected(old('supplier_id')==$s->id)>{{ $s->name }}</option>@endforeach</select></div>
<div class="col-md-3"><label class="form-label">Cost Price</label><input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price',0) }}" required></div>
<div class="col-md-3"><label class="form-label">Sale Price</label><input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price',0) }}" required></div>
<div class="col-md-2"><label class="form-label">Stock</label><input type="number" name="stock_qty" class="form-control" value="{{ old('stock_qty',0) }}" required></div>
<div class="col-md-2"><label class="form-label">Reorder</label><input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level',5) }}" required></div>
<div class="col-md-2"><label class="form-label">Unit</label><input name="unit" class="form-control" value="{{ old('unit','pcs') }}" required></div>
<div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
<div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
</div>
<div class="mt-4"><button class="btn btn-primary">Save Product</button><a href="{{ route('products.index') }}" class="btn btn-light">Cancel</a></div>
</form></div></div>
@endsection
