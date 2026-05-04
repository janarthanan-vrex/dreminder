<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'fcm_token', // ✅ IMPORTANT
        'address1',
        'address2',
        'postcode',
        'country',
        'plan_id',
        'status'
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
}