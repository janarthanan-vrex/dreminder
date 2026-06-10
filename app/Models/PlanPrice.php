<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanPrice extends Model
{
    protected $table = 'plan_price';

    protected $fillable = [
        'color',
        'plan_name',
        'range',
        'icon',
        'description',
        'price',
        'vat',
        'total_price',
        'expiry_date',
        'status',
        'features',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'features' => 'array',
    ];
}

