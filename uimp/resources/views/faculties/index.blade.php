@extends('layouts.app')
@section('title', __('Faculties'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Faculties') }}</h5>
            <a href="{{ route('faculties.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Faculty') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('faculties.index') }}" class="row g-3 mb-3">
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
                    <tr><th>{{ __('Name') }}</th><th>{{ __('Code') }}</th><th>{{ __('Dean') }}</th><th>{{ __('Actions') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($faculties as $faculty)
                        <tr>
                            <td>{{ $faculty->name }}</td>
                            <td>{{ $faculty->code }}</td>
                            <td>{{ $faculty->dean->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('faculties.show', $faculty) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('faculties.destroy', $faculty) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">{{ __('No records found.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $faculties->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
