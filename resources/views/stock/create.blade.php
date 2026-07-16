@extends('layouts.app')
@section('title', 'Adjust Stock')
@section('page_title', 'Adjust Stock')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form method="POST" action="{{ route('stock.store') }}">@csrf
<div class="mb-3"><label class="form-label">Product</label><select name="product_id" class="form-select" required>@foreach($products as $p)<option value="{{ $p->id }}">{{ $p->name }} ({{ $p->stock_qty }} in stock)</option>@endforeach</select></div>
<div class="mb-3"><label class="form-label">Type</label><select name="type" class="form-select"><option value="purchase">Purchase (add)</option><option value="return">Return (add)</option><option value="adjustment">Adjustment (+/-)</option></select></div>
<div class="mb-3"><label class="form-label">Quantity</label><input type="number" name="quantity" class="form-control" required><div class="form-text">Use negative numbers for adjustment decreases.</div></div>
<div class="mb-3"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2"></textarea></div>
<button class="btn btn-primary">Record Movement</button><a href="{{ route('stock.index') }}" class="btn btn-light">Cancel</a>
</form></div></div>
@endsection
