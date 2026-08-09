@extends('layouts.app')
@section('title', __('Students'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Students') }}</h5>
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Student') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('students.index') }}" class="row g-3 mb-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="department_id" class="form-select">
                        <option value="">{{ __('All Departments') }}</option>
                        @foreach($departments as $dep)
                            <option value="{{ $dep->id }}" {{ request('department_id') == $dep->id ? 'selected' : '' }}>{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="academic_status" class="form-select">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('academic_status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="graduated" {{ request('academic_status') == 'graduated' ? 'selected' : '' }}>{{ __('Graduated') }}</option>
                        <option value="suspended" {{ request('academic_status') == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                        <option value="dropped" {{ request('academic_status') == 'dropped' ? 'selected' : '' }}>{{ __('Dropped') }}</option>
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
                        <th>{{ __('Student ID') }}</th>
                        <th>{{ __('Department') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>{{ $student->user->name ?? '' }}</td>
                            <td>{{ $student->user->email ?? '' }}</td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->department->name ?? '' }}</td>
                            <td>{{ $student->academic_status }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
            {{ $students->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
