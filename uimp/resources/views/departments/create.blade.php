@extends('layouts.app')
@section('title', __('Add Department'))
@section('content')
    <div class="card">
        <div class="card-header"><h5>{{ __('Add Department') }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="code" class="form-label">{{ __('Code') }}</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="faculty_id" class="form-label">{{ __('Faculty') }}</label>
                        <select class="form-select @error('faculty_id') is-invalid @enderror" id="faculty_id" name="faculty_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach($faculties as $fac)
                                <option value="{{ $fac->id }}" {{ old('faculty_id') == $fac->id ? 'selected' : '' }}>{{ $fac->name }}</option>
                            @endforeach
                        </select>
                        @error('faculty_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="parent_department_id" class="form-label">{{ __('Parent Department') }}</label>
                        <select class="form-select @error('parent_department_id') is-invalid @enderror" id="parent_department_id" name="parent_department_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach($parents ?? [] as $dep)
                                <option value="{{ $dep->id }}" {{ old('parent_department_id') == $dep->id ? 'selected' : '' }}>{{ $dep->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="head_user_id" class="form-label">{{ __('Head') }}</label>
                        <select class="form-select @error('head_user_id') is-invalid @enderror" id="head_user_id" name="head_user_id">
                            <option value="">{{ __('Select') }}</option>
                            @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" {{ old('head_user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('head_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
