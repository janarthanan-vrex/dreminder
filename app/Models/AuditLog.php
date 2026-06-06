<?php
// app/Models/AuditLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    protected $fillable = [
        'event',
        'module',
        'module_icon',
        'admin_id',
        'admin_name',
        'admin_role',
        'admin_initials',
        'admin_color',
        'admin_bg',
        'ip_address',
        'changes_summary',
        'changes_detail',
    ];

    protected $casts = [
        'changes_detail' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /* ────────────────────────────────────────
     | Static helper — call this everywhere
     ──────────────────────────────────────── */
    public static function record(
        string $event,
        string $module,
        string $changesSummary,
        array  $fields = [],          // [['field'=>'Name','old'=>'A','new'=>'B'], …]
        string $moduleIcon = null
    ): self {
        $admin    = Auth::guard('admin')->user();
        $name     = $admin ? $admin->name    : 'System';
        $role     = $admin ? optional($admin->roles)->rolename ?? 'Admin' : 'System';
        $initials = self::makeInitials($name);

        // Pick a stable avatar colour from a palette
        $palette = [
            ['color' => '#6366f1', 'bg' => '#ede9fe'],
            ['color' => '#d97706', 'bg' => '#fef3c7'],
            ['color' => '#2563eb', 'bg' => '#dbeafe'],
            ['color' => '#0284c7', 'bg' => '#e0f2fe'],
            ['color' => '#7c3aed', 'bg' => '#ede9fe'],
        ];
        $pair = $palette[crc32($name) % count($palette)];

        // Build icon map
        $iconMap = [
            'Products' => 'ri-box-line',
            'Users'    => 'ri-user-line',
            'Orders'   => 'ri-shopping-bag-line',
            'Auth'     => 'ri-shield-check-line',
            'Settings' => 'ri-settings-3-line',
            'Reports'  => 'ri-bar-chart-line',
            'Blog'     => 'ri-article-line',
            'Roles'    => 'ri-shield-user-line',
            'Staff'    => 'ri-team-line',
        ];

        return self::create([
            'event'           => $event,
            'module'          => $module,
            'module_icon'     => $moduleIcon ?? ($iconMap[$module] ?? 'ri-file-line'),
            'admin_id'        => $admin?->id,
            'admin_name'      => $name,
            'admin_role'      => $role,
            'admin_initials'  => $initials,
            'admin_color'     => $pair['color'],
            'admin_bg'        => $pair['bg'],
            'ip_address'      => Request::ip(),
            'changes_summary' => $changesSummary,
            'changes_detail'  => $fields,
        ]);
    }

    private static function makeInitials(string $name): string
    {
        $parts = explode(' ', trim($name));
        $ini   = strtoupper(substr($parts[0], 0, 1));
        if (isset($parts[1])) $ini .= strtoupper(substr($parts[1], 0, 1));
        return $ini;
    }
}