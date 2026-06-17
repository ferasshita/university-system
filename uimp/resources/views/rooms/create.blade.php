@extends('layouts.app')
@section('title', __('Add Room'))
@section('content')
    <div class="card">
        <div class="card-header"><h5>{{ __('Add Room') }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('rooms.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="building_id" class="form-label">{{ __('Building') }}</label>
                        <select class="form-select @error('building_id') is-invalid @enderror" id="building_id" name="building_id" required>
                            <option value="">{{ __('Select') }}</option>
                            @foreach($buildings as $bld)
                                <option value="{{ $bld->id }}" {{ old('building_id') == $bld->id ? 'selected' : '' }}>{{ $bld->name }}</option>
                            @endforeach
                        </select>
                        @error('building_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="room_number" class="form-label">{{ __('Room Number') }}</label>
                        <input type="text" class="form-control @error('room_number') is-invalid @enderror" id="room_number" name="room_number" value="{{ old('room_number') }}" required>
                        @error('room_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Name (optional)') }}</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="capacity" class="form-label">{{ __('Capacity') }}</label>
                        <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity') }}">
                        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">{{ __('Type') }}</label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}">
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="under_maintenance" {{ old('status') == 'under_maintenance' ? 'selected' : '' }}>{{ __('Under Maintenance') }}</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="equipment" class="form-label">{{ __('Equipment (JSON array)') }}</label>
                        <input type="text" class="form-control @error('equipment') is-invalid @enderror" id="equipment" name="equipment" value="{{ old('equipment') }}" placeholder='["projector","whiteboard"]'>
                        @error('equipment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">{{ __('Description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="2">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('Save') }}</button>
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </form>
        </div>
    </div>
@endsection
