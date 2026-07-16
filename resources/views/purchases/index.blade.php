@extends('layouts.app')
@section('title', 'Purchases')
@section('page_title', 'Purchase Orders')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Receive stock from suppliers.</p><a href="{{ route('purchases.create') }}" class="btn btn-primary rounded-pill">New Purchase</a></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>PO #</th><th>Supplier</th><th>Date</th><th>Total</th><th>Status</th><th class="text-end">View</th></tr></thead><tbody>
@forelse($orders as $order)
<tr><td>{{ $order->order_number }}</td><td>{{ $order->supplier->name }}</td><td>{{ $order->order_date->format('M d, Y') }}</td><td>${{ number_format($order->total_amount,2) }}</td><td>{{ ucfirst($order->status) }}</td><td class="text-end"><a href="{{ route('purchases.show',$order) }}" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No purchase orders yet.</td></tr>@endforelse
</tbody></table></div>@if($orders->hasPages())<div class="card-footer bg-white">{{ $orders->links() }}</div>@endif</div>
@endsection
