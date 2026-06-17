@extends('layouts.app')
@section('title', __('Rooms'))
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>{{ __('Rooms') }}</h5>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> {{ __('Add Room') }}
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('rooms.index') }}" class="row g-3 mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('Search...') }}" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="building_id" class="form-select">
                        <option value="">{{ __('All Buildings') }}</option>
                        @foreach($buildings ?? [] as $bld)
                            <option value="{{ $bld->id }}" {{ request('building_id') == $bld->id ? 'selected' : '' }}>{{ $bld->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="under_maintenance" {{ request('status') == 'under_maintenance' ? 'selected' : '' }}>{{ __('Under Maintenance') }}</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr><th>{{ __('Room Number') }}</th><th>{{ __('Name') }}</th><th>{{ __('Building') }}</th><th>{{ __('Capacity') }}</th><th>{{ __('Status') }}</th><th>{{ __('Actions') }}</th></tr>
                    </thead>
                    <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->name ?? '-' }}</td>
                            <td>{{ $room->building->name ?? '-' }}</td>
                            <td>{{ $room->capacity ?? '-' }}</td>
                            <td>{{ $room->status }}</td>
                            <td>
                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
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
            {{ $rooms->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
