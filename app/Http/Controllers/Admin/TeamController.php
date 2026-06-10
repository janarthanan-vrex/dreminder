<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Admin;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class TeamController extends Controller
{
    public function rolesPage(Request $request)
    {
        $roles = Role::withCount('admins')
            ->with(['permissions' => function ($query) {
                $query->wherePivot('is_checked', 1);
            }])
            ->get();
        $rolesData = $roles->map(function ($role) {
            return [
                'id'    => $role->id,
                'name'  => $role->rolename,
                'color' => $role->color,
                'status' => $role->status,
                'desc'  => $role->description ?? '',
                'perms' => $role->permissions->pluck('permission_name')->toArray(),
                'count'  => $role->admins_count,
            ];
        });

        return view('admin.roles', compact('rolesData'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'rolename'    => 'required|string|unique:roles,rolename|max:255',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
            'permissions' => 'nullable|array',
        ], [
            'rolename.required' => 'Role name is required.',
            'rolename.unique'   => 'This role name already exists.',
            'rolename.max'      => 'Role name must not exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $role = Role::create([
            'rolename'    => $request->rolename,
            'description' => $request->description,
            'color'       => $request->color ?? '#7c3aed',
            'status'      => $request->status ?? 'active',
        ]);

        $allPermissions = Permission::all();

        $syncData = [];
        foreach ($allPermissions as $permission) {
            $isChecked = in_array($permission->permission_name, $request->permissions ?? []) ? 1 : 0;
            $syncData[$permission->id] = ['is_checked' => $isChecked];
        }

        $role->permissions()->sync($syncData);

        // ── Audit Log ────────────────────────────────────────────────────────
        $assignedPermissions = collect($allPermissions)
            ->filter(fn($p) => in_array($p->permission_name, $request->permissions ?? []))
            ->pluck('permission_name')
            ->implode(', ');

        AuditLog::record('Created', 'Roles', 'Created Record', [
            ['field' => 'Role Name',    'old' => null, 'new' => $request->rolename],
            ['field' => 'Description',  'old' => null, 'new' => $request->description ?? '—'],
            ['field' => 'Status',       'old' => null, 'new' => ucfirst($request->status ?? 'active')],
            ['field' => 'Permissions',  'old' => null, 'new' => $assignedPermissions ?: 'None'],
        ]);

        return response()->json([
            'role'    => $role,
            'message' => 'Role created successfully',
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'rolename'    => 'required|string|max:255|unique:roles,rolename,' . $role->id,
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
            'permissions' => 'nullable|array',
        ], [
            'rolename.required' => 'Role name is required.',
            'rolename.unique'   => 'This role name already exists.',
            'rolename.max'      => 'Role name must not exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // ── Snapshot BEFORE ───────────────────────────────────────────────────
        $oldPermissions = $role->permissions()
            ->wherePivot('is_checked', 1)
            ->pluck('permission_name')
            ->sort()
            ->implode(', ');

        $before = [
            'rolename'    => $role->rolename,
            'description' => $role->description ?? '—',
            'status'      => ucfirst($role->status),
            'permissions' => $oldPermissions ?: 'None',
        ];

        $role->update([
            'rolename'    => $request->rolename,
            'description' => $request->description,
            'color'       => $request->color ?? $role->color,
            'status'      => $request->status ?? 'active',
        ]);

        $allPermissions = Permission::all();

        $syncData = [];
        foreach ($allPermissions as $permission) {
            $isChecked = in_array($permission->permission_name, $request->permissions ?? []) ? 1 : 0;
            $syncData[$permission->id] = ['is_checked' => $isChecked];
        }

        $role->permissions()->sync($syncData);

        // ── Snapshot AFTER ────────────────────────────────────────────────────
        $newPermissions = collect($allPermissions)
            ->filter(fn($p) => in_array($p->permission_name, $request->permissions ?? []))
            ->pluck('permission_name')
            ->sort()
            ->implode(', ');

        $after = [
            'rolename'    => $request->rolename,
            'description' => $request->description ?? '—',
            'status'      => ucfirst($request->status ?? 'active'),
            'permissions' => $newPermissions ?: 'None',
        ];

        $fieldLabels = [
            'rolename'    => 'Role Name',
            'description' => 'Description',
            'status'      => 'Status',
            'permissions' => 'Permissions',
        ];

        $changedFields = [];
        foreach ($before as $key => $oldVal) {
            if ((string) $oldVal !== (string) $after[$key]) {
                $changedFields[] = [
                    'field' => $fieldLabels[$key],
                    'old'   => $oldVal,
                    'new'   => $after[$key],
                ];
            }
        }

        if (!empty($changedFields)) {
            $summary = count($changedFields) === 1
                ? '1 Field Updated'
                : count($changedFields) . ' Fields Updated';

            AuditLog::record('Updated', 'Roles', $summary, $changedFields);
        }

        return response()->json([
            'role'    => $role,
            'message' => 'Role updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // ── Audit Log BEFORE delete ───────────────────────────────────────────
        $permissions = $role->permissions()
            ->wherePivot('is_checked', 1)
            ->pluck('permission_name')
            ->implode(', ');

        AuditLog::record('Deleted', 'Roles', 'Deleted Record', [
            ['field' => 'Role Name',   'old' => $role->rolename,              'new' => null],
            ['field' => 'Description', 'old' => $role->description ?? '—',   'new' => null],
            ['field' => 'Status',      'old' => ucfirst($role->status),       'new' => null],
            ['field' => 'Permissions', 'old' => $permissions ?: 'None',       'new' => null],
        ]);

        $role->permissions()->detach();
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function staffManagemant()
    {
        $staffs = Admin::with(['roles.permissions' => function ($query) {
            $query->wherePivot('is_checked', 1);
        }])->where('id', '!=', auth()->id()) // exclude logged-in superadmin
            ->get();

        $staffData = $staffs->map(function ($staff) {
            $nameParts = explode(' ', trim($staff->name));
            $initials  = collect($nameParts)->map(fn($w) => strtoupper($w[0]))->take(2)->implode('');

            $perms = [];
            if ($staff->roles) {
                $perms = $staff->roles->permissions->pluck('permission_name')->toArray();
            }

            return [
                'id'       => $staff->id,
                'name'     => $staff->name,
                'email'    => $staff->email,
                'phone'    => $staff->phone,
                'role'     => $staff->role_id,
                'status'   => $staff->status ?? 'active',
                'initials' => $initials,
                'color'    => '#7c3aed',
            ];
        });

        $roles = Role::with(['permissions' => function ($query) {
            $query->wherePivot('is_checked', 1);
        }])->get();

        $rolesAssignedCount = Admin::whereNotNull('role_id')
            ->distinct('role_id')
            ->count('role_id');

        $rolesData = $roles->map(function ($role) {
            return [
                'id'    => $role->id,
                'name'  => $role->rolename,
                'color' => $role->color,
                'desc'  => $role->description ?? '',
                'perms' => $role->permissions->pluck('permission_name')->toArray(),
                'count' => $role->admins()->count(), // requires reverse relation
            ];
        });

        return view('admin.staff', compact('staffData', 'rolesData', 'rolesAssignedCount'));
    }

    public function storeStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255|unique:admins,name',
            'email'   => 'required|email:rfc,dns|unique:admins,email',
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|digits_between:10,15',
            'status'  => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $password = $this->generatePassword();

        $staff = Admin::create([
            'name'     => ucfirst($request->name),
            'email'    => $request->email,
            'role_id'  => $request->role_id,
            'phone'    => $request->phone,
            'status'   => $request->status,
            'password' => Hash::make($password),
        ]);

        $role = Role::find($request->role_id);

        Mail::send('emails.staff_register', [
            'staff'    => $staff,
            'role'     => $role,
            'password' => $password,
        ], function ($m) use ($staff) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($staff->email, $staff->name)
                ->subject('Your Staff Account Credentials');
        });

        // ── Audit Log ────────────────────────────────────────────────────────
        AuditLog::record('Created', 'Staff', 'Created Record', [
            ['field' => 'Name',   'old' => null, 'new' => ucfirst($request->name)],
            ['field' => 'Email',  'old' => null, 'new' => $request->email],
            ['field' => 'Role',   'old' => null, 'new' => $role?->rolename ?? '—'],
            ['field' => 'Phone',  'old' => null, 'new' => $request->phone  ?? '—'],
            ['field' => 'Status', 'old' => null, 'new' => ucfirst($request->status)],
        ]);

        return response()->json([
            'status'   => true,
            'message'  => 'Staff added successfully',
            'password' => $password,
        ]);
    }

    public function updateStaff(Request $request, $id)
    {
        $staff = Admin::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'name'    => 'required|string|max:255|unique:admins,name,' . $id,
            'email'   => 'required|email|unique:admins,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|digits_between:10,15',
            'status'  => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // ── Snapshot BEFORE ───────────────────────────────────────────────────
        $before = [
            'name'   => $staff->name,
            'email'  => $staff->email,
            'role'   => optional($staff->roles)->rolename ?? '—',
            'phone'  => $staff->phone  ?? '—',
            'status' => ucfirst($staff->status),
        ];

        $staff->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'phone'   => $request->phone,
            'status'  => $request->status,
        ]);

        // ── Snapshot AFTER ────────────────────────────────────────────────────
        $newRole = Role::find($request->role_id);

        $after = [
            'name'   => $request->name,
            'email'  => $request->email,
            'role'   => $newRole?->rolename ?? '—',
            'phone'  => $request->phone ?? '—',
            'status' => ucfirst($request->status),
        ];

        $fieldLabels = [
            'name'   => 'Name',
            'email'  => 'Email',
            'role'   => 'Role',
            'phone'  => 'Phone',
            'status' => 'Status',
        ];

        $changedFields = [];
        foreach ($before as $key => $oldVal) {
            if ((string) $oldVal !== (string) $after[$key]) {
                $changedFields[] = [
                    'field' => $fieldLabels[$key],
                    'old'   => $oldVal,
                    'new'   => $after[$key],
                ];
            }
        }

        if (!empty($changedFields)) {
            $summary = count($changedFields) === 1
                ? '1 Field Updated'
                : count($changedFields) . ' Fields Updated';

            AuditLog::record('Updated', 'Staff', $summary, $changedFields);
        }

        return response()->json(['message' => 'Staff updated successfully']);
    }

    public function destroyStaff($id)
    {
        $staff = Admin::findOrFail($id);

        // ── Audit Log BEFORE delete ───────────────────────────────────────────
        AuditLog::record('Deleted', 'Staff', 'Deleted Record', [
            ['field' => 'Name',   'old' => $staff->name,                             'new' => null],
            ['field' => 'Email',  'old' => $staff->email,                            'new' => null],
            ['field' => 'Role',   'old' => optional($staff->roles)->rolename ?? '—', 'new' => null],
            ['field' => 'Status', 'old' => ucfirst($staff->status),                  'new' => null],
        ]);

        $staff->delete();

        return response()->json(['message' => 'Staff removed successfully']);
    }

    private function generatePassword($length = 10)
    {
        $upper   = chr(rand(65, 90));
        $lower   = chr(rand(97, 122));
        $number  = rand(0, 9);
        $special = '!@#$%^&*'[rand(0, 7)];

        $remaining = Str::random($length - 4);

        return str_shuffle(
            $upper . $lower . $number . $special . $remaining
        );
    }
}
