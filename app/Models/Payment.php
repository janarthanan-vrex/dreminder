<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_holder_name',
        'card_last_four',
        'exp_month',
        'exp_year',
        'stripe_payment_id',
        'discount',
        'amount',
        'currency',
        'status',
    ];
}