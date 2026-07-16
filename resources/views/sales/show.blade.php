@extends('layouts.app')
@section('title', $sale->sale_number)
@section('page_title', $sale->sale_number)
@section('content')
<div class="card border-0 shadow-sm p-4 mb-4"><h4 class="fw-bold">{{ $sale->sale_number }}</h4><p>Customer: {{ $sale->customer_name ?? 'Walk-in' }}</p><p>Subtotal: ${{ number_format($sale->subtotal,2) }} | Discount: ${{ number_format($sale->discount,2) }} | Tax: ${{ number_format($sale->tax,2) }}</p><h5>Total: ${{ number_format($sale->total,2) }}</h5></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>@foreach($sale->items as $item)<tr><td>{{ $item->product_name }}</td><td>{{ $item->quantity }}</td><td>${{ number_format($item->unit_price,2) }}</td><td>${{ number_format($item->subtotal,2) }}</td></tr>@endforeach</tbody></table></div></div>
@endsection
