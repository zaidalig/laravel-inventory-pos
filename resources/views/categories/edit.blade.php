@extends('layouts.app')
@section('title', 'Edit Category')
@section('page_title', 'Edit Category')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form method="POST" action="{{ route('categories.update',$category) }}">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name',$category->name) }}" required></div>
<div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$category->description) }}</textarea></div>
<div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" @selected(old('status',$category->status)==='active')>Active</option><option value="inactive" @selected(old('status',$category->status)==='inactive')>Inactive</option></select></div>
<button class="btn btn-primary">Update</button><a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
</form></div></div>
@endsection
