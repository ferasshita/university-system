@extends('layouts.app')
@section('title', __('Add Subsystem'))
@section('content')
    <div class="card">
        <div class="card-header"><h5>{{ __('Add Subsystem') }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('subsystems.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">{{ __('Slug') }}</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" required>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="version" class="form-label">{{ __('Version') }}</label>
                        <input type="text" class="form-control @error('version') is-invalid @enderror" id="version" name="version" value="{{ old('version', '1.0') }}">
                        @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="api_base_url" class="form-label">{{ __('API Base URL') }}</label>
                        <input type="url" class="form-control @error('api_base_url') is-invalid @enderror" id="api_base_url" name="api_base_url" value="{{ old('api_base_url') }}" placeholder="https://api.example.com">
                        @error('api_base_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="is_active" class="form-label">{{ __('Status') }}</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                        @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="config" class="form-label">{{ __('Configuration (JSON)') }}</label>
                        <input type="text" class="form-control @error('config') is-invalid @enderror" id="config" name="config" value="{{ old('config') }}" placeholder='{"key":"value"}'>
                        @error('config')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                <a href="{{ route('subsystems.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
