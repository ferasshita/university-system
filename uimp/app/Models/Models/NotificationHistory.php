<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'template_id', 'channel', 'subject', 'body',
        'sent_at', 'status', 'error_message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(NotificationTemplate::class);
    }
}
