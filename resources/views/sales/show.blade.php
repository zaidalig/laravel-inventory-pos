@extends('layouts.app')
@section('title', $sale->sale_number)
@section('page_title', $sale->sale_number)
@section('content')
<div class="card border-0 shadow-sm p-4 mb-4">
<div class="d-flex justify-content-between align-items-start">
<div><h4 class="fw-bold">{{ $sale->sale_number }} @if($sale->status==='voided')<span class="badge bg-danger-subtle text-danger">Voided</span>@endif</h4><p class="mb-1">Customer: {{ $sale->customer_name ?? 'Walk-in' }}</p><p class="mb-1">Payment: {{ ucfirst(str_replace('_',' ',$sale->payment_method)) }}</p><p class="mb-0">Subtotal: ${{ number_format($sale->subtotal,2) }} | Discount: ${{ number_format($sale->discount,2) }} | Tax: ${{ number_format($sale->tax,2) }}</p><h5 class="mt-2 mb-0">Total: ${{ number_format($sale->total,2) }}</h5></div>
@if($sale->status==='completed')
@can('void-sales')
<form method="POST" action="{{ route('sales.void',$sale) }}" onsubmit="return confirm('Void this sale and restore stock?')">@csrf @method('PATCH')<button class="btn btn-outline-danger"><i class="fa-solid fa-rotate-left"></i> Void Sale</button></form>
@endcan
@endif
</div>
</div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>@foreach($sale->items as $item)<tr><td>{{ $item->product_name }}</td><td>{{ $item->quantity }}</td><td>${{ number_format($item->unit_price,2) }}</td><td>${{ number_format($item->subtotal,2) }}</td></tr>@endforeach</tbody></table></div></div>
@endsection
