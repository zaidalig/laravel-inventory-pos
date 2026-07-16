@extends('layouts.app')
@section('title', 'Suppliers')
@section('page_title', 'Suppliers')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Manage vendor contacts and purchase sources.</p><a href="{{ route('suppliers.create') }}" class="btn btn-primary rounded-pill">Add Supplier</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2"><div class="col-md-5"><input name="search" class="form-control" placeholder="Search name, email, phone" value="{{ request('search') }}"></div><div class="col-md-3"><select name="status" class="form-select"><option value="">All</option><option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option></select></div><div class="col-md-4"><button class="btn btn-dark w-100">Filter</button></div></form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Name</th><th>Contact</th><th>Products</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($suppliers as $supplier)
<tr><td><a href="{{ route('suppliers.show',$supplier) }}" class="fw-bold text-decoration-none">{{ $supplier->name }}</a></td><td><div class="small">{{ $supplier->email ?? '-' }}</div><div class="small text-muted">{{ $supplier->phone ?? '-' }}</div></td><td>{{ $supplier->products_count }}</td><td>{{ ucfirst($supplier->status) }}</td>
<td class="text-end"><a href="{{ route('suppliers.edit',$supplier) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a><button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('suppliers.destroy',$supplier) }}" data-name="{{ $supplier->name }}"><i class="fa-solid fa-trash"></i></button></td></tr>
@empty<tr><td colspan="5" class="text-center py-4 text-muted">No suppliers found.</td></tr>@endforelse
</tbody></table></div>@if($suppliers->hasPages())<div class="card-footer bg-white">{{ $suppliers->links() }}</div>@endif</div>
@endsection
