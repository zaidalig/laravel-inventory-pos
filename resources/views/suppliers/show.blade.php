@extends('layouts.app')
@section('title', $supplier->name)
@section('page_title', $supplier->name)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card border-0 shadow-sm p-4"><h5 class="fw-bold">{{ $supplier->name }}</h5><p class="text-muted mb-1">{{ $supplier->email }}</p><p class="text-muted mb-1">{{ $supplier->phone }}</p><p class="text-muted">{{ $supplier->address }}</p><a href="{{ route('suppliers.edit',$supplier) }}" class="btn btn-sm btn-outline-primary mt-2">Edit</a></div></div>
<div class="col-lg-8"><div class="card card-table border-0"><div class="card-header bg-white fw-bold">Products</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>SKU</th><th>Name</th><th>Stock</th></tr></thead><tbody>@forelse($supplier->products as $p)<tr><td>{{ $p->sku }}</td><td><a href="{{ route('products.show',$p) }}">{{ $p->name }}</a></td><td>{{ $p->stock_qty }}</td></tr>@empty<tr><td colspan="3" class="text-center py-3 text-muted">No products.</td></tr>@endforelse</tbody></table></div></div></div>
</div>
@endsection
