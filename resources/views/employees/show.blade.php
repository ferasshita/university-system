@extends('layouts.app')
@section('title', __('Employee Details'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Employee Details') }}</h5>
            <div>
                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>{{ __('Full Name') }}:</strong> {{ $employee->user->name }}</p>
                    <p><strong>{{ __('Email') }}:</strong> {{ $employee->user->email }}</p>
                    <p><strong>{{ __('Employee ID') }}:</strong> {{ $employee->employee_id }}</p>
                    <p><strong>{{ __('Department') }}:</strong> {{ $employee->department->name ?? '-' }}</p>
                    <p><strong>{{ __('Employment Type') }}:</strong> {{ $employee->employment_type }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>{{ __('Academic Rank') }}:</strong> {{ $employee->academic_rank ?? '-' }}</p>
                    <p><strong>{{ __('Hire Date') }}:</strong> {{ $employee->hire_date ?? '-' }}</p>
                    <p><strong>{{ __('Termination Date') }}:</strong> {{ $employee->termination_date ?? '-' }}</p>
                    <p><strong>{{ __('Phone') }}:</strong> {{ $employee->user->phone ?? '-' }}</p>
                    <p><strong>{{ __('Institutional ID') }}:</strong> {{ $employee->user->institutional_id ?? '-' }}</p>
                </div>
            </div>
            <hr>
            <p><strong>{{ __('Additional Data') }}:</strong> <pre>{{ json_encode($employee->additional_data, JSON_PRETTY_PRINT) }}</pre></p>
            <p><strong>{{ __('Created At') }}:</strong> {{ $employee->created_at }}</p>
            <p><strong>{{ __('Updated At') }}:</strong> {{ $employee->updated_at }}</p>
        </div>
    </div>
@endsection
