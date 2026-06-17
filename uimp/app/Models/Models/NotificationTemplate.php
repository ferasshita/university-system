<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use HasUuids;

    protected $fillable = ['slug', 'subject', 'body', 'channel', 'is_active'];

    protected $casts = [
        'subject' => 'array',
        'body' => 'array',
        'is_active' => 'boolean',
    ];
}
