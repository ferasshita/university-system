<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name', 'code', 'campus_id', 'address', 'floors',
        'contact_info', 'status', 'created_by', 'modified_by'
    ];

    protected $casts = ['contact_info' => 'array'];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
