@extends('layouts.app')
@section('title', 'Add User')
@section('page_title', 'Add User')
@section('content')
<div class="card border-0 shadow-sm"><div class="card-body p-4"><form method="POST" action="{{ route('users.store') }}">@csrf @include('users._form')<button class="btn btn-primary">Save</button></form></div></div>
@endsection
