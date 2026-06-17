<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'name' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'equipment' => 'nullable|array',
            'status' => 'nullable|in:active,under_maintenance,inactive',
            'type' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ];
    }
}
