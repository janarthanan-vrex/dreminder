<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'admin_id',
        'user_id',
        'module',
        'action',
        'description',
        'ip_address',
    ];
}