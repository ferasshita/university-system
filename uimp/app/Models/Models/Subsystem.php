<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Subsystem extends Model
{
    use HasUuids;

    protected $fillable = [
        'name', 'slug', 'version', 'api_base_url', 'config',
        'is_active', 'created_by', 'modified_by'
    ];

    protected $casts = ['config' => 'array', 'is_active' => 'boolean'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
