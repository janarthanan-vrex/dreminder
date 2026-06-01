<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderHistory extends Model
{
    use HasFactory;
    protected $table = 'reminder_histories';
    protected $fillable = [
        'user_id',
        'reminder_id',
        'reminder_date',
        'reminder_time',
        'status',
        'sent_at',
    ];
    protected $casts = [
        'reminder_date' => 'date',
        'sent_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reminder()
    {
        return $this->belongsTo(Reminder::class);
    }
}