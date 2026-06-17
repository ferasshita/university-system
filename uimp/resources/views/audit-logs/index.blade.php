@extends('layouts.app')
@section('title', __('Audit Logs'))
@section('content')
    <div class="card">
        <div class="card-header">
            <h5>{{ __('Audit Logs') }}</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('audit-logs.index') }}" class="row g-3 mb-3">
                <div class="col-md-3">
                    <input type="text" name="user_id" class="form-control" placeholder="{{ __('User ID') }}" value="{{ request('user_id') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="action" class="form-control" placeholder="{{ __('Action') }}" value="{{ request('action') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="resource_type" class="form-control" placeholder="{{ __('Resource Type') }}" value="{{ request('resource_type') }}">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div class="col-md-4">
                    <input type="date" name="from_date" class="form-control" placeholder="{{ __('From') }}" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-4">
                    <input type="date" name="to_date" class="form-control" placeholder="{{ __('To') }}" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-filter"></i> {{ __('Filter by Date') }}</button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr><th>{{ __('User') }}</th><th>{{ __('Action') }}</th><th>{{ __('Resource') }}</th><th>{{ __('Timestamp') }}</th><th>{{ __('Actions') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->resource_type }} ({{ $log->resource_id }})</td>
                            <td>{{ $log->created_at }}</td>
                            <td>
                                <a href="{{ route('audit-logs.show', $log) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">{{ __('No records found.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
