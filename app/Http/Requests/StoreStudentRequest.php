<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or use permissions
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'sometimes|string|min:6',
            'institutional_id' => 'nullable|string|max:50|unique:users,institutional_id',
            'phone' => 'nullable|string|max:20',
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'department_id' => 'nullable|exists:departments,id',
            'academic_status' => 'nullable|in:active,graduated,suspended,dropped',
            'enrollment_date' => 'nullable|date',
            'program' => 'nullable|string|max:255',
            'current_year' => 'nullable|integer|min:1',
            'additional_data' => 'nullable|array',
        ];
    }
}
