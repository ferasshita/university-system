<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Http\Resources\FacultyResource;
use App\Models\Faculty;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $query = Faculty::with('dean');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        return FacultyResource::collection($query->paginate(15));
    }

    public function store(StoreFacultyRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $faculty = Faculty::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'faculty.created',
            'resource_type' => 'faculty',
            'resource_id' => $faculty->id,
            'new_data' => $faculty->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new FacultyResource($faculty->load('dean'));
    }

    public function show(Faculty $faculty)
    {
        return new FacultyResource($faculty->load('dean', 'departments'));
    }

    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        $oldData = $faculty->toArray();
        $faculty->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'faculty.updated',
            'resource_type' => 'faculty',
            'resource_id' => $faculty->id,
            'old_data' => $oldData,
            'new_data' => $faculty->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new FacultyResource($faculty->load('dean'));
    }

    public function destroy(Faculty $faculty)
    {
        $oldData = $faculty->toArray();
        $faculty->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'faculty.deleted',
            'resource_type' => 'faculty',
            'resource_id' => $faculty->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return response()->json(null, 204);
    }
}
