@extends('layouts.app')
@section('title', 'Activity Logs')
@section('page_title', 'Activity Logs')
@section('content')
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Action</th><th>Description</th><th>User</th><th>When</th></tr></thead><tbody>
@forelse($logs as $log)
<tr><td>{{ $log->action }}</td><td>{{ $log->description }}</td><td>{{ $log->user?->name ?? 'System' }}</td><td>{{ $log->created_at->format('M d, Y H:i') }}</td></tr>
@empty<tr><td colspan="4" class="text-center py-4 text-muted">No activity yet.</td></tr>@endforelse
</tbody></table></div>@if($logs->hasPages())<div class="card-footer bg-white">{{ $logs->links() }}</div>@endif</div>
@endsection
