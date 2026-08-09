<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubsystemRequest;
use App\Http\Requests\UpdateSubsystemRequest;
use App\Http\Resources\SubsystemResource;
use App\Models\Subsystem;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class SubsystemController extends Controller
{
    public function index(Request $request)
    {
        $query = Subsystem::query();

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        return SubsystemResource::collection($query->paginate(15));
    }

    public function store(StoreSubsystemRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $subsystem = Subsystem::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.created',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'new_data' => $subsystem->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new SubsystemResource($subsystem);
    }

    public function show(Subsystem $subsystem)
    {
        return new SubsystemResource($subsystem);
    }

    public function update(UpdateSubsystemRequest $request, Subsystem $subsystem)
    {
        $oldData = $subsystem->toArray();
        $subsystem->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.updated',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'old_data' => $oldData,
            'new_data' => $subsystem->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new SubsystemResource($subsystem);
    }

    public function destroy(Subsystem $subsystem)
    {
        $oldData = $subsystem->toArray();
        $subsystem->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.deleted',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return response()->json(null, 204);
    }

    // Additional endpoint to toggle active status
    public function toggleActive(Request $request, Subsystem $subsystem)
    {
        $oldData = $subsystem->toArray();
        $subsystem->is_active = !$subsystem->is_active;
        $subsystem->save();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'subsystem.toggled',
            'resource_type' => 'subsystem',
            'resource_id' => $subsystem->id,
            'old_data' => $oldData,
            'new_data' => $subsystem->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new SubsystemResource($subsystem);
    }
}
