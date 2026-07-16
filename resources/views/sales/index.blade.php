@extends('layouts.app')
@section('title', 'Sales')
@section('page_title', 'Sales / POS')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Completed point-of-sale transactions.</p><a href="{{ route('sales.create') }}" class="btn btn-primary rounded-pill">New Sale</a></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Sale #</th><th>Customer</th><th>Total</th><th>Payment</th><th>Cashier</th><th class="text-end">View</th></tr></thead><tbody>
@forelse($sales as $sale)
<tr><td>{{ $sale->sale_number }}</td><td>{{ $sale->customer_name ?? 'Walk-in' }}</td><td>${{ number_format($sale->total,2) }}</td><td>{{ ucfirst(str_replace('_',' ',$sale->payment_method)) }}</td><td>{{ $sale->user?->name ?? '-' }}</td><td class="text-end"><a href="{{ route('sales.show',$sale) }}" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No sales yet.</td></tr>@endforelse
</tbody></table></div>@if($sales->hasPages())<div class="card-footer bg-white">{{ $sales->links() }}</div>@endif</div>
@endsection
