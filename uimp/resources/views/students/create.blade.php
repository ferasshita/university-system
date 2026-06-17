@extends('layouts.app')
@section('title', __('Add Student'))
@section('content')
    <div class="card">
        <div class="card-header"><h5>{{ __('Add Student') }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('students.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="student_id" class="form-label">{{ __('Student ID') }}</label>
                        <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                        @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="department_id" class="form-label">{{ __('Department') }}</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach($departments as $dep)
                                <option value="{{ $dep->id }}" {{ old('department_id') == $dep->id ? 'selected' : '' }}>{{ $dep->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="academic_status" class="form-label">{{ __('Academic Status') }}</label>
                        <select class="form-select @error('academic_status') is-invalid @enderror" id="academic_status" name="academic_status">
                            <option value="active" {{ old('academic_status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="graduated" {{ old('academic_status') == 'graduated' ? 'selected' : '' }}>{{ __('Graduated') }}</option>
                            <option value="suspended" {{ old('academic_status') == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                            <option value="dropped" {{ old('academic_status') == 'dropped' ? 'selected' : '' }}>{{ __('Dropped') }}</option>
                        </select>
                        @error('academic_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="program" class="form-label">{{ __('Program') }}</label>
                        <input type="text" class="form-control @error('program') is-invalid @enderror" id="program" name="program" value="{{ old('program') }}">
                        @error('program')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="current_year" class="form-label">{{ __('Current Year') }}</label>
                        <input type="number" class="form-control @error('current_year') is-invalid @enderror" id="current_year" name="current_year" value="{{ old('current_year') }}">
                        @error('current_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="enrollment_date" class="form-label">{{ __('Enrollment Date') }}</label>
                        <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date') }}">
                        @error('enrollment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">{{ __('Phone') }}</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="institutional_id" class="form-label">{{ __('Institutional ID') }}</label>
                        <input type="text" class="form-control @error('institutional_id') is-invalid @enderror" id="institutional_id" name="institutional_id" value="{{ old('institutional_id') }}">
                        @error('institutional_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="text-muted">{{ __('Leave blank to use default.') }}</small>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
