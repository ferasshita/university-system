<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'code', 'address', 'city', 'country', 'contact_info', 'created_by', 'modified_by'];

    protected $casts = ['contact_info' => 'array'];

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }
}
