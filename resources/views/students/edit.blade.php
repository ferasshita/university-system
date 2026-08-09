@extends('layouts.app')
@section('title', __('Edit Student'))
@section('content')
    <div class="card">
        <div class="card-header"><h5>{{ __('Edit Student') }}: {{ $student->user->name }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $student->user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $student->user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="student_id" class="form-label">{{ __('Student ID') }}</label>
                        <input type="text" class="form-control @error('student_id') is-invalid @enderror" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" required>
                        @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="department_id" class="form-label">{{ __('Department') }}</label>
                        <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach($departments as $dep)
                                <option value="{{ $dep->id }}" {{ old('department_id', $student->department_id) == $dep->id ? 'selected' : '' }}>{{ $dep->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="academic_status" class="form-label">{{ __('Academic Status') }}</label>
                        <select class="form-select @error('academic_status') is-invalid @enderror" id="academic_status" name="academic_status">
                            <option value="active" {{ old('academic_status', $student->academic_status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="graduated" {{ old('academic_status', $student->academic_status) == 'graduated' ? 'selected' : '' }}>{{ __('Graduated') }}</option>
                            <option value="suspended" {{ old('academic_status', $student->academic_status) == 'suspended' ? 'selected' : '' }}>{{ __('Suspended') }}</option>
                            <option value="dropped" {{ old('academic_status', $student->academic_status) == 'dropped' ? 'selected' : '' }}>{{ __('Dropped') }}</option>
                        </select>
                        @error('academic_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="program" class="form-label">{{ __('Program') }}</label>
                        <input type="text" class="form-control @error('program') is-invalid @enderror" id="program" name="program" value="{{ old('program', $student->program) }}">
                        @error('program')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="current_year" class="form-label">{{ __('Current Year') }}</label>
                        <input type="number" class="form-control @error('current_year') is-invalid @enderror" id="current_year" name="current_year" value="{{ old('current_year', $student->current_year) }}">
                        @error('current_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="enrollment_date" class="form-label">{{ __('Enrollment Date') }}</label>
                        <input type="date" class="form-control @error('enrollment_date') is-invalid @enderror" id="enrollment_date" name="enrollment_date" value="{{ old('enrollment_date', $student->enrollment_date) }}">
                        @error('enrollment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">{{ __('Phone') }}</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $student->user->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="institutional_id" class="form-label">{{ __('Institutional ID') }}</label>
                        <input type="text" class="form-control @error('institutional_id') is-invalid @enderror" id="institutional_id" name="institutional_id" value="{{ old('institutional_id', $student->user->institutional_id) }}">
                        @error('institutional_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">{{ __('New Password (optional)') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        <small class="text-muted">{{ __('Leave blank to keep current.') }}</small>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Update') }}</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
