<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:buildings,code',
            'campus_id' => 'nullable|exists:campuses,id',
            'address' => 'nullable|string',
            'floors' => 'nullable|integer|min:0',
            'contact_info' => 'nullable|array',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
