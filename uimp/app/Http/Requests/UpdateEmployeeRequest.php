<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employee = $this->route('employee');
        $userId = $employee?->user_id;

        return [
            'department_id' => 'nullable|exists:departments,id',
            'employment_type' => 'nullable|in:academic,non_academic',
            'academic_rank' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date|after:hire_date',
            'additional_data' => 'nullable|array',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$userId,
            'phone' => 'nullable|string|max:20',
            'institutional_id' => 'nullable|string|max:50|unique:users,institutional_id,'.$userId,
        ];
    }
}
