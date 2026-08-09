<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'department']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('employment_type')) {
            $query->where('employment_type', $request->employment_type);
        }

        $employees = $query->paginate(15);
        return EmployeeResource::collection($employees);
    }

    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Create user if not exists
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'] ?? 'password'),
                'institutional_id' => $validated['institutional_id'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'is_active' => true,
            ]);

            $employee = Employee::create([
                'user_id' => $user->id,
                'employee_id' => $validated['employee_id'],
                'department_id' => $validated['department_id'] ?? null,
                'employment_type' => $validated['employment_type'] ?? 'non_academic',
                'academic_rank' => $validated['academic_rank'] ?? null,
                'hire_date' => $validated['hire_date'] ?? null,
                'termination_date' => $validated['termination_date'] ?? null,
                'additional_data' => $validated['additional_data'] ?? [],
                'created_by' => auth()->id(),
            ]);

            $user->assignRole('Employee');

            dispatch(new AuditLogJob([
                'user_id' => auth()->id(),
                'action' => 'employee.created',
                'resource_type' => 'employee',
                'resource_id' => $employee->id,
                'new_data' => $employee->toArray(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]));

            DB::commit();
            return new EmployeeResource($employee->load('user', 'department'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create employee: ' . $e->getMessage()], 500);
        }
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee->load('user', 'department'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $oldData = $employee->toArray();
        $employee->update($request->validated());

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'employee.updated',
            'resource_type' => 'employee',
            'resource_id' => $employee->id,
            'old_data' => $oldData,
            'new_data' => $employee->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new EmployeeResource($employee->load('user', 'department'));
    }

    public function destroy(Employee $employee)
    {
        $oldData = $employee->toArray();
        $employee->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'employee.deleted',
            'resource_type' => 'employee',
            'resource_id' => $employee->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return response()->json(null, 204);
    }
}
