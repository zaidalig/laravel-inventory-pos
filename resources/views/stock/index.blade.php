@extends('layouts.app')
@section('title', 'Stock')
@section('page_title', 'Stock Movements')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Inventory in/out ledger.</p><a href="{{ route('stock.create') }}" class="btn btn-primary rounded-pill">Adjust Stock</a></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Product</th><th>Type</th><th>Qty</th><th>Before</th><th>After</th><th>User</th><th>Date</th></tr></thead><tbody>
@forelse($movements as $m)
<tr><td>{{ $m->product->name }}</td><td>{{ $m->type }}</td><td>{{ $m->quantity }}</td><td>{{ $m->stock_before }}</td><td>{{ $m->stock_after }}</td><td>{{ $m->user?->name ?? '-' }}</td><td>{{ $m->created_at->format('M d, Y H:i') }}</td></tr>
@empty<tr><td colspan="7" class="text-center py-4 text-muted">No stock movements.</td></tr>@endforelse
</tbody></table></div>@if($movements->hasPages())<div class="card-footer bg-white">{{ $movements->links() }}</div>@endif</div>
@endsection
