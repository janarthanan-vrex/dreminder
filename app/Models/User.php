<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Reminder;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PlanPrice;
use App\Models\Category;
use App\Models\SubCategory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verification_code',
        'password',
        'profile',
        'phone',
        'fcm_token', 
        'address1',
        'address2',
        'postcode',
        'country',
        'plan_id',
        'status',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function plan()
    {
        return $this->belongsTo(PlanPrice::class);
    }
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);      
    }
    public function notificationSetting()
{
    return $this->hasOne(UserNotificationSetting::class);
}
}