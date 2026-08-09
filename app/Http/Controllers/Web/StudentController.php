<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use App\Jobs\AuditLogJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search and filters.
     */
    public function index(Request $request)
    {
        $query = Student::with(['user', 'department']);

        // Search by name, email, or student ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by academic status
        if ($request->filled('academic_status')) {
            $query->where('academic_status', $request->academic_status);
        }

        $students = $query->paginate(15);
        $departments = Department::all();

        return view('students.index', compact('students', 'departments'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $departments = Department::all();
        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'] ?? 'password'),
                'institutional_id' => $validated['institutional_id'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'is_active' => true,
            ]);

            // Create student profile
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

            // Assign role (requires Spatie Permission)
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

            return redirect()->route('students.index')
                ->with('success', __('Student created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => __('Failed to create student: ') . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load(['user', 'department']);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $departments = Department::all();
        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $oldData = $student->toArray();

        // Update student fields (excluding user fields)
        $student->update($request->only([
            'student_id',
            'department_id',
            'academic_status',
            'enrollment_date',
            'program',
            'current_year',
            'additional_data'
        ]));

        // Update associated user if provided
        if ($request->filled('name') || $request->filled('email') || $request->filled('phone')) {
            $user = $student->user;
            if ($user) {
                $user->update($request->only(['name', 'email', 'phone', 'institutional_id']));
                // Optionally update password if provided
                if ($request->filled('password')) {
                    $user->update(['password' => bcrypt($request->password)]);
                }
            }
        }

        // Audit log
        dispatch(new AuditLogJob([
            'user_id' => auth()->id(),
            'action' => 'student.updated',
            'resource_type' => 'student',
            'resource_id' => $student->id,
            'old_data' => $oldData,
            'new_data' => $student->fresh()->toArray(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]));

        return redirect()->route('students.index')
            ->with('success', __('Student updated successfully.'));
    }

    /**
     * Remove the specified student from storage (soft delete).
     */
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

        return redirect()->route('students.index')
            ->with('success', __('Student deleted successfully.'));
    }
}
