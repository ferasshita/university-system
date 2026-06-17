<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'sometimes|string|min:6',
            'institutional_id' => 'nullable|string|max:50|unique:users,institutional_id',
            'phone' => 'nullable|string|max:20',
            'employee_id' => 'required|string|max:50|unique:employees,employee_id',
            'department_id' => 'nullable|exists:departments,id',
            'employment_type' => 'nullable|in:academic,non_academic',
            'academic_rank' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date|after:hire_date',
            'additional_data' => 'nullable|array',
        ];
    }
}
