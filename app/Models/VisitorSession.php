<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorSession extends Model
{
    protected $fillable = [
        'session_id',
        'ip_hash',
        'user_agent',
        'device_type',
        'current_url',
        'referrer',
        'last_activity',
    ];

    protected function casts(): array
    {
        return [
            'last_activity' => 'datetime',
        ];
    }
}
