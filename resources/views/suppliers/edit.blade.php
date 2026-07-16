@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('page_title', 'Edit Supplier')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form method="POST" action="{{ route('suppliers.update',$supplier) }}">@csrf @method('PUT')
<div class="row g-3"><div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name',$supplier->name) }}" required></div><div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email',$supplier->email) }}"></div><div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone',$supplier->phone) }}"></div><div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" @selected(old('status',$supplier->status)==='active')>Active</option><option value="inactive" @selected(old('status',$supplier->status)==='inactive')>Inactive</option></select></div><div class="col-12"><label class="form-label">Address</label><input name="address" class="form-control" value="{{ old('address',$supplier->address) }}"></div></div>
<div class="mt-4"><button class="btn btn-primary">Update</button><a href="{{ route('suppliers.show',$supplier) }}" class="btn btn-light">Back</a></div>
</form></div></div>
@endsection
