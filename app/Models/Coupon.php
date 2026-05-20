<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'discount',
        'start_date',
        'expiry_date',
        'status',
        'coupon_type',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expiry_date' => 'date',
    ];
}