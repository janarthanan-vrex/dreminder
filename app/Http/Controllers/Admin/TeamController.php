<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class TeamController extends Controller
{
    public function rolesPage(Request $request)
    {
        $roles = Role::with(['permissions' => function ($query) {
            $query->wherePivot('is_checked', 1);
        }])->get();

        $rolesData = $roles->map(function ($role) {
            return [
                'id'    => $role->id,
                'name'  => $role->rolename,
                'color' => $role->color,
                'status' => $role->status,
                'desc'  => $role->description ?? '',
                'perms' => $role->permissions->pluck('permission_name')->toArray(),
                'count' => 0, // replace with staff count if you have that relation
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
                'errors' => $validator->errors()
            ], 422);
        }

        $role = Role::create([
            'rolename'    => $request->rolename,
            'description' => $request->description,
            'color'       => $request->color ?? '#7c3aed',
            'status'      =>  $request->status ?? 'active',
        ]);

        $allPermissions = Permission::all();

        $syncData = [];
        foreach ($allPermissions as $permission) {
            $isChecked = in_array($permission->permission_name, $request->permissions ?? []) ? 1 : 0;
            $syncData[$permission->id] = ['is_checked' => $isChecked];
        }

        $role->permissions()->sync($syncData);

        return response()->json([
            'role'    => $role,
            'message' => 'Role created successfully'
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
                'errors' => $validator->errors()
            ], 422);
        }

        $role->update([
            'rolename'    => $request->rolename,
            'description' => $request->description,
            'color'       => $request->color ?? $role->color,
            'status'      =>  $request->status ?? 'active',
        ]);

        $allPermissions = Permission::all();

        $syncData = [];
        foreach ($allPermissions as $permission) {
            $isChecked = in_array($permission->permission_name, $request->permissions ?? []) ? 1 : 0;
            $syncData[$permission->id] = ['is_checked' => $isChecked];
        }

        $role->permissions()->sync($syncData);

        return response()->json([
            'role'    => $role,
            'message' => 'Role updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->detach(); // clean pivot rows
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
            'email' => 'required|email:rfc,dns|unique:admins,email',
            'role_id' => 'required|exists:roles,id',
            'phone'   => 'nullable|digits_between:10,15',
            'status'  => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
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
        return response()->json([
            'status'   => true,
            'message'  => 'Staff added successfully',
            'password' => $password
        ]);
    }

    public function updateStaff(Request $request, $id)
    {
        $staff = Admin::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'name'    => 'required|string|max:255|unique:admins,name,' . $id,
            'email'   => 'required|email|unique:admins,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|digits_between:10,15',
            'status'  => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // dd( $request->status);

        $staff->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
            'phone'   => $request->phone,
            'status'  => $request->status,
        ]);

        return response()->json(['message' => 'Staff updated successfully']);
    }

    public function destroyStaff($id)
    {
        $staff = Admin::findOrFail($id);
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
