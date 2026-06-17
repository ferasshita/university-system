<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with(['faculty', 'head', 'parentDepartment']);
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }
        if ($request->has('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }
        $departments = $query->paginate(15);
        $faculties = Faculty::all();
        return view('departments.index', compact('departments', 'faculties'));
    }

    public function create()
    {
        $faculties = Faculty::all();
        $parents = Department::all();
        $users = User::role('Academic Staff')->get();
        return view('departments.create', compact('faculties', 'parents', 'users'));
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

        return redirect()->route('departments.index')->with('success', __('Department created successfully.'));
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $faculties = Faculty::all();
        $parents = Department::where('id', '!=', $department->id)->get();
        $users = User::role('Academic Staff')->get();
        return view('departments.edit', compact('department', 'faculties', 'parents', 'users'));
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

        return redirect()->route('departments.index')->with('success', __('Department updated successfully.'));
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

        return redirect()->route('departments.index')->with('success', __('Department deleted successfully.'));
    }
}
