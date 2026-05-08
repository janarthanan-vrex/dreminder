<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'status',
        'color',
        'icon',
        'is_special',
        'role',
        'created_by_id',
    ];

    public function subcategories()
{
    return $this->hasMany(SubCategory::class, 'category_id');
}
public function reminders()
{
    return $this->hasMany(Reminder::class);
}

    
}