<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedback';
    protected $fillable = [
        'user_id',
        'subject',
        'priority',
        'message',
        'feedback_status',
        'admin_reply',
        'is_receive',
    ];
    protected $casts = [
        'is_receive' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}