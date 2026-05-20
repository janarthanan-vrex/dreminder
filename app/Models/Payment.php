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
        'payment_mode',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
}