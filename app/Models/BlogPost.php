<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'featured_image',
        'category', 'is_active',
        'seo_title', 'meta_description', 'focus_keyword',
        'keywords', 'canonical', 'robots',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}