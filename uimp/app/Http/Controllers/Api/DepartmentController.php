<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with(['faculty', 'head', 'parentDepartment']);

        if ($request->has('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        return DepartmentResource::collection($query->paginate(15));
    }

    public function store(StoreDepartmentRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        $department = Department::create($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'department.created',
            'resource_type' => 'department',
            'resource_id' => $department->id,
            'new_data' => $department->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new DepartmentResource($department->load(['faculty', 'head', 'parentDepartment']));
    }

    public function show(Department $department)
    {
        return new DepartmentResource($department->load(['faculty', 'head', 'parentDepartment', 'childDepartments']));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $oldData = $department->toArray();
        $department->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'department.updated',
            'resource_type' => 'department',
            'resource_id' => $department->id,
            'old_data' => $oldData,
            'new_data' => $department->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new DepartmentResource($department->load(['faculty', 'head', 'parentDepartment']));
    }

    public function destroy(Department $department)
    {
        $oldData = $department->toArray();
        $department->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'department.deleted',
            'resource_type' => 'department',
            'resource_id' => $department->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return response()->json(null, 204);
    }
}
