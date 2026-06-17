<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Models\User;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Student::class, 'student');
    }

    public function index(Request $request)
    {
        $query = Student::with(['user', 'department']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('academic_status')) {
            $query->where('academic_status', $request->academic_status);
        }

        $students = $query->paginate(15);

        return StudentResource::collection($students);
    }

    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Create user if not exists (or we could expect user_id)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'] ?? 'password'), // temp
                'institutional_id' => $validated['institutional_id'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'is_active' => true,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'student_id' => $validated['student_id'],
                'department_id' => $validated['department_id'] ?? null,
                'academic_status' => $validated['academic_status'] ?? 'active',
                'enrollment_date' => $validated['enrollment_date'] ?? null,
                'program' => $validated['program'] ?? null,
                'current_year' => $validated['current_year'] ?? null,
                'additional_data' => $validated['additional_data'] ?? [],
                'created_by' => auth()->id(),
            ]);

            // Assign role 'Student' if using Spatie
            $user->assignRole('Student');

            // Audit log
            dispatch(new AuditLogJob([
                'user_id' => auth()->id(),
                'action' => 'student.created',
                'resource_type' => 'student',
                'resource_id' => $student->id,
                'new_data' => $student->toArray(),
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]));

            DB::commit();
            return new StudentResource($student->load('user', 'department'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create student: ' . $e->getMessage()], 500);
        }
    }

    public function show(Student $student)
    {
        return new StudentResource($student->load('user', 'department'));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        $oldData = $student->toArray();

        $student->update($validated);

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'student.updated',
            'resource_type' => 'student',
            'resource_id' => $student->id,
            'old_data' => $oldData,
            'new_data' => $student->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return new StudentResource($student->load('user', 'department'));
    }

    public function destroy(Student $student)
    {
        $oldData = $student->toArray();
        $student->delete();

        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'student.deleted',
            'resource_type' => 'student',
            'resource_id' => $student->id,
            'old_data' => $oldData,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return response()->json(null, 204);
    }
}
