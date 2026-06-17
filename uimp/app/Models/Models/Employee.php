<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id', 'employee_id', 'department_id', 'employment_type',
        'academic_rank', 'hire_date', 'termination_date', 'additional_data',
        'created_by', 'modified_by'
    ];

    protected $casts = ['additional_data' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
