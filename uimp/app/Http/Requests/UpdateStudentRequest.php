<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $userId = $student?->user_id;
        $studentId = $student?->id;

        return [
            'department_id' => 'nullable|exists:departments,id',
            'academic_status' => 'nullable|in:active,graduated,suspended,dropped',
            'enrollment_date' => 'nullable|date',
            'graduation_date' => 'nullable|date',
            'program' => 'nullable|string|max:255',
            'current_year' => 'nullable|integer|min:1',
            'additional_data' => 'nullable|array',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$userId,
            'phone' => 'nullable|string|max:20',
            'institutional_id' => 'nullable|string|max:50|unique:users,institutional_id,'.$userId,
            'student_id' => 'sometimes|required|string|max:50|unique:students,student_id,'.$studentId,
        ];
    }
}
