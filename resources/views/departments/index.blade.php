@extends('layouts.app')
@section('title', __('Departments'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Departments') }}</h5>
            <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Department') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('departments.index') }}" class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="faculty_id" class="form-select">
                        <option value="">{{ __('All Faculties') }}</option>
                        @foreach($faculties ?? [] as $fac)
                            <option value="{{ $fac->id }}" {{ request('faculty_id') == $fac->id ? 'selected' : '' }}>{{ $fac->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr><th>{{ __('Name') }}</th><th>{{ __('Code') }}</th><th>{{ __('Faculty') }}</th><th>{{ __('Head') }}</th><th>{{ __('Actions') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->code }}</td>
                            <td>{{ $department->faculty->name ?? '-' }}</td>
                            <td>{{ $department->head->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
            {{ $departments->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
