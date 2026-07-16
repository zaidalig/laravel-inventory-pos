@extends('layouts.app')
@section('title', 'Stock')
@section('page_title', 'Stock Movements')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Inventory in/out ledger.</p><a href="{{ route('stock.create') }}" class="btn btn-primary rounded-pill">Adjust Stock</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2"><div class="col-md-4"><select name="product_id" class="form-select"><option value="">All Products</option>@foreach($products as $p)<option value="{{ $p->id }}" @selected(request('product_id')==$p->id)>{{ $p->name }}</option>@endforeach</select></div><div class="col-md-3"><select name="type" class="form-select"><option value="">All Types</option>@foreach(['purchase','sale','adjustment','return'] as $t)<option value="{{ $t }}" @selected(request('type')===$t)>{{ ucfirst($t) }}</option>@endforeach</select></div><div class="col-md-5 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['product_id','type']))<a href="{{ route('stock.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div></form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Product</th><th>Type</th><th>Qty</th><th>Before</th><th>After</th><th>User</th><th>Date</th></tr></thead><tbody>
@forelse($movements as $m)
<tr><td>{{ $m->product->name }}</td><td>{{ $m->type }}</td><td>{{ $m->quantity }}</td><td>{{ $m->stock_before }}</td><td>{{ $m->stock_after }}</td><td>{{ $m->user?->name ?? '-' }}</td><td>{{ $m->created_at->format('M d, Y H:i') }}</td></tr>
@empty<tr><td colspan="7" class="text-center py-4 text-muted">No stock movements.</td></tr>@endforelse
</tbody></table></div>@if($movements->hasPages())<div class="card-footer bg-white">{{ $movements->links() }}</div>@endif</div>
@endsection
