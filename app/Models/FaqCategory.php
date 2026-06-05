<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FaqCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color', 'is_visible', 'sort_order',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class)->orderBy('sort_order');
    }

    protected static function booted(): void
    {
        static::creating(function ($cat) {
            if (empty($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }
}