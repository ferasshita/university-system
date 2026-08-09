@extends('layouts.app')
@section('title', __('Campuses'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Campuses') }}</h5>
            <a href="{{ route('campuses.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Campus') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('campuses.index') }}" class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr><th>{{ __('Name') }}</th><th>{{ __('Code') }}</th><th>{{ __('City') }}</th><th>{{ __('Country') }}</th><th>{{ __('Actions') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($campuses as $campus)
                        <tr>
                            <td>{{ $campus->name }}</td>
                            <td>{{ $campus->code }}</td>
                            <td>{{ $campus->city ?? '-' }}</td>
                            <td>{{ $campus->country ?? '-' }}</td>
                            <td>
                                <a href="{{ route('campuses.show', $campus) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('campuses.edit', $campus) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('campuses.destroy', $campus) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">{{ __('No records found.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $campuses->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
