@extends('layouts.app')
@section('title', $purchase->order_number)
@section('page_title', $purchase->order_number)
@section('content')
<div class="card border-0 shadow-sm p-4 mb-4"><h4 class="fw-bold">{{ $purchase->order_number }}</h4><p class="mb-1">Supplier: {{ $purchase->supplier->name }}</p><p class="mb-1">Date: {{ $purchase->order_date->format('M d, Y') }}</p><p class="mb-0">Total: <strong>${{ number_format($purchase->total_amount,2) }}</strong></p></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Product</th><th>Qty</th><th>Unit Cost</th><th>Subtotal</th></tr></thead><tbody>@foreach($purchase->items as $item)<tr><td>{{ $item->product->name }}</td><td>{{ $item->quantity }}</td><td>${{ number_format($item->unit_cost,2) }}</td><td>${{ number_format($item->subtotal,2) }}</td></tr>@endforeach</tbody></table></div></div>
@endsection
