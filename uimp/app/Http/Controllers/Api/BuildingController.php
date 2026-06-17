<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Http\Resources\BuildingResource;
use App\Models\Building;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $query = Building::with('campus');

        if ($request->has('campus_id')) {
            $query->where('campus_id', $request->campus_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return BuildingResource::collection($query->paginate(15));
    }

    public function store(StoreBuildingRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $building = Building::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'building.created',
            'resource_type' => 'building',
            'resource_id' => $building->id,
            'new_data' => $building->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new BuildingResource($building->load('campus'));
    }

    public function show(Building $building)
    {
        return new BuildingResource($building->load(['campus', 'rooms']));
    }

    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $oldData = $building->toArray();
        $building->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'building.updated',
            'resource_type' => 'building',
            'resource_id' => $building->id,
            'old_data' => $oldData,
            'new_data' => $building->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new BuildingResource($building->load('campus'));
    }

    public function destroy(Building $building)
    {
        $oldData = $building->toArray();
        $building->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'building.deleted',
            'resource_type' => 'building',
            'resource_id' => $building->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return response()->json(null, 204);
    }
}
