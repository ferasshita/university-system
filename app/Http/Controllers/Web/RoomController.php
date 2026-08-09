<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\Building;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('building');
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('room_number', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%");
        }
        if ($request->has('building_id')) {
            $query->where('building_id', $request->building_id);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $rooms = $query->paginate(15);
        $buildings = Building::all();
        return view('rooms.index', compact('rooms', 'buildings'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('rooms.create', compact('buildings'));
    }

    public function store(StoreRoomRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $room = Room::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'room.created',
            'resource_type' => 'room',
            'resource_id' => $room->id,
            'new_data' => $room->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('rooms.index')->with('success', __('Room created successfully.'));
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $buildings = Building::all();
        return view('rooms.edit', compact('room', 'buildings'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $oldData = $room->toArray();
        $room->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'room.updated',
            'resource_type' => 'room',
            'resource_id' => $room->id,
            'old_data' => $oldData,
            'new_data' => $room->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('rooms.index')->with('success', __('Room updated successfully.'));
    }

    public function destroy(Room $room)
    {
        $oldData = $room->toArray();
        $room->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'room.deleted',
            'resource_type' => 'room',
            'resource_id' => $room->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('rooms.index')->with('success', __('Room deleted successfully.'));
    }
}
