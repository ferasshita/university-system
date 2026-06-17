@extends('layouts.app')
@section('title', __('Audit Log Details'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Audit Log Details') }}</h5>
            <a href="{{ route('audit-logs.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
        </div>
        <div class="card-body">
            <p><strong>{{ __('User') }}:</strong> {{ $auditLog->user->name ?? '-' }}</p>
            <p><strong>{{ __('Action') }}:</strong> {{ $auditLog->action }}</p>
            <p><strong>{{ __('Resource Type') }}:</strong> {{ $auditLog->resource_type }}</p>
            <p><strong>{{ __('Resource ID') }}:</strong> {{ $auditLog->resource_id }}</p>
            <p><strong>{{ __('IP Address') }}:</strong> {{ $auditLog->ip ?? '-' }}</p>
            <p><strong>{{ __('User Agent') }}:</strong> {{ $auditLog->user_agent ?? '-' }}</p>
            <p><strong>{{ __('Timestamp') }}:</strong> {{ $auditLog->created_at }}</p>
            <hr>
            <p><strong>{{ __('Old Data') }}:</strong></p>
            <pre>{{ json_encode($auditLog->old_data, JSON_PRETTY_PRINT) }}</pre>
            <p><strong>{{ __('New Data') }}:</strong></p>
            <pre>{{ json_encode($auditLog->new_data, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
@endsection
