@extends('layouts.app')
@section('title', __('Student Details'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Student Details') }}</h5>
            <div>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>{{ __('Full Name') }}:</strong> {{ $student->user->name }}</p>
                    <p><strong>{{ __('Email') }}:</strong> {{ $student->user->email }}</p>
                    <p><strong>{{ __('Student ID') }}:</strong> {{ $student->student_id }}</p>
                    <p><strong>{{ __('Department') }}:</strong> {{ $student->department->name ?? '-' }}</p>
                    <p><strong>{{ __('Academic Status') }}:</strong> {{ $student->academic_status }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>{{ __('Program') }}:</strong> {{ $student->program ?? '-' }}</p>
                    <p><strong>{{ __('Current Year') }}:</strong> {{ $student->current_year ?? '-' }}</p>
                    <p><strong>{{ __('Enrollment Date') }}:</strong> {{ $student->enrollment_date ?? '-' }}</p>
                    <p><strong>{{ __('Phone') }}:</strong> {{ $student->user->phone ?? '-' }}</p>
                    <p><strong>{{ __('Institutional ID') }}:</strong> {{ $student->user->institutional_id ?? '-' }}</p>
                </div>
            </div>
            <hr>
            <p><strong>{{ __('Additional Data') }}:</strong> <pre>{{ json_encode($student->additional_data, JSON_PRETTY_PRINT) }}</pre></p>
            <p><strong>{{ __('Created At') }}:</strong> {{ $student->created_at }}</p>
            <p><strong>{{ __('Updated At') }}:</strong> {{ $student->updated_at }}</p>
        </div>
    </div>
@endsection
