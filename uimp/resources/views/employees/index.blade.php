@extends('layouts.app')
@section('title', __('Employees'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Employees') }}</h5>
            <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Employee') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('employees.index') }}" class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="department_id" class="form-select">
                        <option value="">{{ __('All Departments') }}</option>
                        @foreach($departments ?? [] as $dep)
                            <option value="{{ $dep->id }}" {{ request('department_id') == $dep->id ? 'selected' : '' }}>{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="employment_type" class="form-select">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="academic" {{ request('employment_type') == 'academic' ? 'selected' : '' }}>{{ __('Academic') }}</option>
                        <option value="non_academic" {{ request('employment_type') == 'non_academic' ? 'selected' : '' }}>{{ __('Non-Academic') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Employee ID') }}</th>
                        <th>{{ __('Department') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->user->name ?? '' }}</td>
                            <td>{{ $employee->user->email ?? '' }}</td>
                            <td>{{ $employee->employee_id }}</td>
                            <td>{{ $employee->department->name ?? '' }}</td>
                            <td>{{ $employee->employment_type }}</td>
                            <td>
                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">{{ __('No records found.') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $employees->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
