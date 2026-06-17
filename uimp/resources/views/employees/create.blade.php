@extends('layouts.app')
@section('title', __('Add Employee'))
@section('content')
    <div class="card">
        <div class="card-header"><h5>{{ __('Add Employee') }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('employees.store') }}">
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
                        <label for="employee_id" class="form-label">{{ __('Employee ID') }}</label>
                        <input type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" required>
                        @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        <label for="employment_type" class="form-label">{{ __('Employment Type') }}</label>
                        <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type" name="employment_type">
                            <option value="non_academic" {{ old('employment_type') == 'non_academic' ? 'selected' : '' }}>{{ __('Non-Academic') }}</option>
                            <option value="academic" {{ old('employment_type') == 'academic' ? 'selected' : '' }}>{{ __('Academic') }}</option>
                        </select>
                        @error('employment_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="academic_rank" class="form-label">{{ __('Academic Rank') }}</label>
                        <input type="text" class="form-control @error('academic_rank') is-invalid @enderror" id="academic_rank" name="academic_rank" value="{{ old('academic_rank') }}">
                        @error('academic_rank')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hire_date" class="form-label">{{ __('Hire Date') }}</label>
                        <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date') }}">
                        @error('hire_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="termination_date" class="form-label">{{ __('Termination Date') }}</label>
                        <input type="date" class="form-control @error('termination_date') is-invalid @enderror" id="termination_date" name="termination_date" value="{{ old('termination_date') }}">
                        @error('termination_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
