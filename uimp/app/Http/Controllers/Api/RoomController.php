<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('building');

        // Filter by building
        if ($request->has('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by capacity min
        if ($request->has('capacity_min')) {
            $query->where('capacity', '>=', $request->capacity_min);
        }

        // Filter by equipment (JSON contains)
        if ($request->has('equipment')) {
            $equipment = (array) $request->equipment;
            foreach ($equipment as $item) {
                $query->whereJsonContains('equipment', $item);
            }
        }

        // Search by room number or name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Availability filter: if start_time and end_time provided, we could check booking conflicts,
        // but that logic is in the Room Subsystem. We only provide room catalog.
        // Optionally, we can add a flag to filter rooms that are not under maintenance.
        $rooms = $query->paginate(15);
        return RoomResource::collection($rooms);
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

        return new RoomResource($room->load('building'));
    }

    public function show(Room $room)
    {
        return new RoomResource($room->load('building'));
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

        return new RoomResource($room->load('building'));
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

        return response()->json(null, 204);
    }
}
