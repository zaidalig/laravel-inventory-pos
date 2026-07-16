@extends('layouts.app')
@section('title', 'Dashboard')
@section('page_title', 'Store Dashboard')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4 col-xl"><div class="card stat-card card-primary p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Products</div><h3 class="fw-bold mb-0">{{ $stats['products'] }}</h3></div><div class="card-icon bg-primary-subtle text-primary"><i class="fa-solid fa-boxes-stacked"></i></div></div></div></div>
    <div class="col-md-4 col-xl"><div class="card stat-card card-danger p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Low Stock</div><h3 class="fw-bold mb-0">{{ $stats['low_stock'] }}</h3></div><div class="card-icon bg-danger-subtle text-danger"><i class="fa-solid fa-triangle-exclamation"></i></div></div></div></div>
    <div class="col-md-4 col-xl"><div class="card stat-card card-success p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Sales Today</div><h3 class="fw-bold mb-0">${{ number_format($stats['sales_today'], 2) }}</h3></div><div class="card-icon bg-success-subtle text-success"><i class="fa-solid fa-cash-register"></i></div></div></div></div>
    <div class="col-md-4 col-xl"><div class="card stat-card card-info p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Suppliers</div><h3 class="fw-bold mb-0">{{ $stats['suppliers'] }}</h3></div><div class="card-icon bg-info-subtle text-info"><i class="fa-solid fa-truck-field"></i></div></div></div></div>
    <div class="col-md-4 col-xl"><div class="card stat-card card-warning p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">Pending POs</div><h3 class="fw-bold mb-0">{{ $stats['purchases_pending'] }}</h3></div><div class="card-icon bg-warning-subtle text-warning"><i class="fa-solid fa-cart-flatbed"></i></div></div></div></div>
</div>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-table border-0">
            <div class="card-header bg-white fw-bold">Low Stock Alerts</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Product</th><th>Stock</th><th>Reorder</th></tr></thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                        <tr>
                            <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                            <td><span class="badge bg-danger-subtle text-danger">{{ $product->stock_qty }}</span></td>
                            <td>{{ $product->reorder_level }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">All products are above reorder level.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-table border-0">
            <div class="card-header bg-white fw-bold">Recent Sales</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Sale #</th><th>Total</th><th>By</th></tr></thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->sale_number }}</a></td>
                            <td>${{ number_format($sale->total, 2) }}</td>
                            <td>{{ $sale->user?->name ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-4">No sales yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card card-table border-0 mt-4">
    <div class="card-header bg-white fw-bold">Latest Activity</div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light"><tr><th>Action</th><th>Description</th><th>User</th><th>When</th></tr></thead>
            <tbody>
                @foreach($recentLogs as $log)
                <tr>
                    <td><span class="badge bg-light text-dark border">{{ $log->action }}</span></td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->user?->name ?? 'System' }}</td>
                    <td class="text-muted small">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
