<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'reminder_id',
        'description',
        'is_auto_generate',
    ];

    protected $casts = [
        'is_auto_generate' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}