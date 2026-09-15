<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_desktop',
        'image_mobile',
        'link_url',
        'button_text',
        'type',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getDesktopImageUrlAttribute(): string
    {
        if (str_starts_with($this->image_desktop, 'http')) {
            return $this->image_desktop;
        }
        return asset('storage/' . $this->image_desktop);
    }

    public function getMobileImageUrlAttribute(): string
    {
        if ($this->image_mobile) {
            if (str_starts_with($this->image_mobile, 'http')) {
                return $this->image_mobile;
            }
            return asset('storage/' . $this->image_mobile);
        }
        return $this->desktop_image_url;
    }
}
