@extends('layouts.app')
@section('title', __('Subsystems'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Subsystems') }}</h5>
            <a href="{{ route('subsystems.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Subsystem') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('subsystems.index') }}" class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr><th>{{ __('Name') }}</th><th>{{ __('Slug') }}</th><th>{{ __('Version') }}</th><th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($subsystems as $subsystem)
                        <tr>
                            <td>{{ $subsystem->name }}</td>
                            <td>{{ $subsystem->slug }}</td>
                            <td>{{ $subsystem->version }}</td>
                            <td>
                            <span class="badge {{ $subsystem->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $subsystem->is_active ? __('Active') : __('Inactive') }}
                            </span>
                            </td>
                            <td>
                                <a href="{{ route('subsystems.show', $subsystem) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('subsystems.edit', $subsystem) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('subsystems.destroy', $subsystem) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                <form action="{{ route('subsystems.toggle', $subsystem) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $subsystem->is_active ? 'btn-warning' : 'btn-success' }}">
                                        {{ $subsystem->is_active ? __('Deactivate') : __('Activate') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">{{ __('No records found.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $subsystems->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
