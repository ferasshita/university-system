<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id', 'student_id', 'department_id', 'academic_status',
        'enrollment_date', 'graduation_date', 'program', 'current_year',
        'additional_data', 'created_by', 'modified_by'
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
