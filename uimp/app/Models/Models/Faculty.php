<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faculty extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'code', 'description', 'dean_user_id', 'created_by', 'modified_by'];

    protected $casts = [
        'dean_user_id' => 'string',
    ];

    public function dean()
    {
        return $this->belongsTo(User::class, 'dean_user_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}
