<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $table = 'reminders';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'end_reminder_date',
        'reminder_date',
        'reminder_time',
        'description',
        'provider',
        'cost',
        'payment_frequency',
        'status',
    ];

   

    // Optional relationships (recommended)

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}