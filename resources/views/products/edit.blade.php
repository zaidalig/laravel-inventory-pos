@extends('layouts.app')
@section('title', 'Edit Product')
@section('page_title', 'Edit Product')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form method="POST" action="{{ route('products.update',$product) }}" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-4"><label class="form-label">SKU</label><input name="sku" class="form-control" value="{{ old('sku',$product->sku) }}" required></div>
<div class="col-md-8"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name',$product->name) }}" required></div>
<div class="col-md-6"><label class="form-label">Category</label><select name="category_id" class="form-select"><option value="">None</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(old('category_id',$product->category_id)==$cat->id)>{{ $cat->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Supplier</label><select name="supplier_id" class="form-select"><option value="">None</option>@foreach($suppliers as $s)<option value="{{ $s->id }}" @selected(old('supplier_id',$product->supplier_id)==$s->id)>{{ $s->name }}</option>@endforeach</select></div>
<div class="col-md-3"><label class="form-label">Cost Price</label><input type="number" step="0.01" name="cost_price" class="form-control" value="{{ old('cost_price',$product->cost_price) }}" required></div>
<div class="col-md-3"><label class="form-label">Sale Price</label><input type="number" step="0.01" name="sale_price" class="form-control" value="{{ old('sale_price',$product->sale_price) }}" required></div>
<div class="col-md-2"><label class="form-label">Stock</label><input type="number" name="stock_qty" class="form-control" value="{{ old('stock_qty',$product->stock_qty) }}" required></div>
<div class="col-md-2"><label class="form-label">Reorder</label><input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level',$product->reorder_level) }}" required></div>
<div class="col-md-2"><label class="form-label">Unit</label><input name="unit" class="form-control" value="{{ old('unit',$product->unit) }}" required></div>
<div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" @selected(old('status',$product->status)==='active')>Active</option><option value="inactive" @selected(old('status',$product->status)==='inactive')>Inactive</option></select></div>
<div class="col-md-6"><label class="form-label">Image</label>@if($product->image_path)<div class="mb-2"><img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" style="width:64px;height:64px;object-fit:cover;border-radius:8px;"></div>@endif<input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp"><div class="form-text">Leave empty to keep the current image.</div>@error('image')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$product->description) }}</textarea></div>
</div>
<div class="mt-4"><button class="btn btn-primary">Update</button><a href="{{ route('products.show',$product) }}" class="btn btn-light">Back</a></div>
</form></div></div>
@endsection
