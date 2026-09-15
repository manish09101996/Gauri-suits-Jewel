<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'content',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
