<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'user_notification_settings';

    protected $fillable = [
        'user_id',

        // Notification channels
        'email_notify',
        'push_notify',

        // Alert timings
        'before_30_days',
        'before_7_days',
        'before_3_days',
        'before_1_day',
        'on_day',

        'quit_hours',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'email_notify'   => 'boolean',
        'push_notify'    => 'boolean',

        'before_30_days' => 'boolean',
        'before_7_days'  => 'boolean',
        'before_3_days'  => 'boolean',
        'before_1_day'   => 'boolean',
        'on_day'         => 'boolean',
    ];

    /**
     * User relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}