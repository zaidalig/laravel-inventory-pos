@extends('layouts.app')
@section('title', 'Purchases')
@section('page_title', 'Purchase Orders')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Receive stock from suppliers.</p><a href="{{ route('purchases.create') }}" class="btn btn-primary rounded-pill">New Purchase</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2"><div class="col-md-5"><input name="search" class="form-control" placeholder="Search PO number" value="{{ request('search') }}"></div><div class="col-md-3"><select name="status" class="form-select"><option value="">All Statuses</option>@foreach(['pending','received','cancelled'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div><div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['search','status']))<a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div></form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>PO #</th><th>Supplier</th><th>Date</th><th>Total</th><th>Status</th><th class="text-end">View</th></tr></thead><tbody>
@forelse($orders as $order)
<tr><td>{{ $order->order_number }}</td><td>{{ $order->supplier->name }}</td><td>{{ $order->order_date->format('M d, Y') }}</td><td>${{ number_format($order->total_amount,2) }}</td><td>{{ ucfirst($order->status) }}</td><td class="text-end"><a href="{{ route('purchases.show',$order) }}" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No purchase orders yet.</td></tr>@endforelse
</tbody></table></div>@if($orders->hasPages())<div class="card-footer bg-white">{{ $orders->links() }}</div>@endif</div>
@endsection
