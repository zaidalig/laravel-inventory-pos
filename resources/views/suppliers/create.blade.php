@extends('layouts.app')
@section('title', 'Add Supplier')
@section('page_title', 'Add Supplier')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form method="POST" action="{{ route('suppliers.store') }}">@csrf
<div class="row g-3"><div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name') }}" required></div><div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}"></div><div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone') }}"></div><div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div><div class="col-12"><label class="form-label">Address</label><input name="address" class="form-control" value="{{ old('address') }}"></div></div>
<div class="mt-4"><button class="btn btn-primary">Save</button><a href="{{ route('suppliers.index') }}" class="btn btn-light">Cancel</a></div>
</form></div></div>
@endsection
