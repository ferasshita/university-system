<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'building_id', 'room_number', 'name', 'capacity', 'equipment',
        'status', 'type', 'description', 'created_by', 'modified_by'
    ];

    protected $casts = ['equipment' => 'array'];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    // Additional scope for availability (used by room subsystem)
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'active');
    }
}
