<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'color',
    'plan_name',
    'range',
    'price',
    'vat',
    'total_price',
    'expiry_date',
    'status',
    'features'
])]
class PlanPrice extends Model
{
    protected $table = 'plan_price';

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
        ];
    }
}