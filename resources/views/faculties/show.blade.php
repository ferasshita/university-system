@extends('layouts.app')
@section('title', __('Faculty Details'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ __('Faculty Details') }}</h5>
            <div>
                <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> {{ __('Edit') }}</a>
                <a href="{{ route('faculties.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>{{ __('Name') }}:</strong> {{ $faculty->name }}</p>
            <p><strong>{{ __('Code') }}:</strong> {{ $faculty->code }}</p>
            <p><strong>{{ __('Description') }}:</strong> {{ $faculty->description ?? '-' }}</p>
            <p><strong>{{ __('Dean') }}:</strong> {{ $faculty->dean->name ?? '-' }}</p>
            <p><strong>{{ __('Created At') }}:</strong> {{ $faculty->created_at }}</p>
            <p><strong>{{ __('Updated At') }}:</strong> {{ $faculty->updated_at }}</p>
        </div>
    </div>
@endsection
