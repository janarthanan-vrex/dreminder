<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'phone',
        'status',
        'password',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
        'profile_image'
        
    ];

    // Hidden fields
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
}
