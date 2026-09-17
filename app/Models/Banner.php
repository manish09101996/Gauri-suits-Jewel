<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'kicker',
        'subtitle',
        'image_desktop',
        'image_mobile',
        'link_url',
        'button_text',
        'tagline',
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
        if (empty($this->image_desktop)) {
            return 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=85&w=2400&auto=format&fit=crop';
        }
        if (str_starts_with($this->image_desktop, 'http')) {
            return $this->image_desktop;
        }
        return asset('storage/' . $this->image_desktop);
    }

    public function getMobileImageUrlAttribute(): string
    {
        if (!empty($this->image_mobile)) {
            if (str_starts_with($this->image_mobile, 'http')) {
                return $this->image_mobile;
            }
            return asset('storage/' . $this->image_mobile);
        }
        return $this->desktop_image_url;
    }
}
