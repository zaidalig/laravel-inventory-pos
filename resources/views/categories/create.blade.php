@extends('layouts.app')
@section('title', 'Add Category')
@section('page_title', 'Add Category')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form method="POST" action="{{ route('categories.store') }}">@csrf
<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea></div>
<div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
<button class="btn btn-primary">Save Category</button>
<a href="{{ route('categories.index') }}" class="btn btn-light">Cancel</a>
</form></div></div>
@endsection
