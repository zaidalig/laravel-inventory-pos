@extends('layouts.app')
@section('title', $product->name)
@section('page_title', $product->name)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card border-0 shadow-sm p-4"><h4 class="fw-bold">{{ $product->name }}</h4><p class="text-muted">SKU: {{ $product->sku }}</p><p>Category: {{ $product->category?->name ?? '-' }}</p><p>Supplier: {{ $product->supplier?->name ?? '-' }}</p><p>Stock: <strong>{{ $product->stock_qty }} {{ $product->unit }}</strong></p><p>Cost: ${{ number_format($product->cost_price,2) }} | Price: ${{ number_format($product->sale_price,2) }}</p><a href="{{ route('products.edit',$product) }}" class="btn btn-sm btn-outline-primary">Edit</a></div></div>
<div class="col-lg-8"><div class="card card-table border-0"><div class="card-header bg-white fw-bold">Stock Movements</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Type</th><th>Qty</th><th>Before</th><th>After</th><th>Ref</th><th>Date</th></tr></thead><tbody>@forelse($product->stockMovements as $m)<tr><td>{{ $m->type }}</td><td>{{ $m->quantity }}</td><td>{{ $m->stock_before }}</td><td>{{ $m->stock_after }}</td><td>{{ $m->reference ?? '-' }}</td><td>{{ $m->created_at->format('M d, Y') }}</td></tr>@empty<tr><td colspan="6" class="text-center py-3 text-muted">No movements yet.</td></tr>@endforelse</tbody></table></div></div></div>
</div>
@endsection
