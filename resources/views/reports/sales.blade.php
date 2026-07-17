@extends('layouts.app')
@section('title', 'Sales Report')
@section('page_title', 'Sales Report')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Filter sales by date range and export CSV.</p>
<a href="{{ route('reports.sales', ['from'=>$from,'to'=>$to,'export'=>1]) }}" class="btn btn-success rounded-pill"><i class="fa-solid fa-file-csv me-1"></i>Export CSV</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2 align-items-end">
<div class="col-md-4"><label class="form-label">From</label><input type="date" name="from" class="form-control" value="{{ $from }}" required></div>
<div class="col-md-4"><label class="form-label">To</label><input type="date" name="to" class="form-control" value="{{ $to }}" required></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button><a href="{{ route('reports.sales') }}" class="btn btn-outline-secondary w-100">Reset</a></div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Sale #</th><th>Date</th><th>Customer</th><th>Total</th><th>Items</th><th>Cashier</th></tr></thead><tbody>
@forelse($sales as $sale)
<tr>
<td>{{ $sale->sale_number }}</td>
<td>{{ $sale->created_at->format('M d, Y H:i') }}</td>
<td>{{ $sale->customer_name ?? 'Walk-in' }}</td>
<td>${{ number_format($sale->total,2) }}</td>
<td>{{ $sale->items->count() }}</td>
<td>{{ $sale->user?->name ?? '-' }}</td>
</tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No sales in this date range.</td></tr>@endforelse
</tbody></table></div>@include('components.table-pagination', ['paginator'=>$sales, 'sorts'=>['created_at'=>'Created','sale_number'=>'Sale #','total'=>'Total']])</div>
@endsection
