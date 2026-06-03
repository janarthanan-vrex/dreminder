<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Users
            ['module' => 'Users', 'permission_name' => 'users.view'],
            ['module' => 'Users', 'permission_name' => 'users.create'],
            ['module' => 'Users', 'permission_name' => 'users.edit'],
            ['module' => 'Users', 'permission_name' => 'users.delete'],

            // Reminders
            ['module' => 'Reminders', 'permission_name' => 'reminders.view'],

            // Calendar
            ['module' => 'Calendar', 'permission_name' => 'calendar.view'],

            // Transactions
            ['module' => 'Transactions', 'permission_name' => 'transaction.view'],

            // Categories
            ['module' => 'Categories', 'permission_name' => 'categories.view'],
            ['module' => 'Categories', 'permission_name' => 'categories.create'],
            ['module' => 'Categories', 'permission_name' => 'categories.edit'],
            ['module' => 'Categories', 'permission_name' => 'categories.delete'],

            // Notifications
            ['module' => 'Notifications', 'permission_name' => 'notifications.view'],
            ['module' => 'Notifications', 'permission_name' => 'notifications.action'],

            // Pricing
            ['module' => 'Pricing', 'permission_name' => 'pricing.view'],
            ['module' => 'Pricing', 'permission_name' => 'pricing.create'],
            ['module' => 'Pricing', 'permission_name' => 'pricing.edit'],
            ['module' => 'Pricing', 'permission_name' => 'pricing.delete'],

            // Coupons
            ['module' => 'Coupons', 'permission_name' => 'coupons.view'],
            ['module' => 'Coupons', 'permission_name' => 'coupons.create'],
            ['module' => 'Coupons', 'permission_name' => 'coupons.edit'],
            ['module' => 'Coupons', 'permission_name' => 'coupons.delete'],

            // Blogs
            ['module' => 'Blogs', 'permission_name' => 'blogs.view'],
            ['module' => 'Blogs', 'permission_name' => 'blogs.create'],
            ['module' => 'Blogs', 'permission_name' => 'blogs.edit'],
            ['module' => 'Blogs', 'permission_name' => 'blogs.delete'],

            // Staffs
            ['module' => 'Staffs', 'permission_name' => 'staffs.view'],
            ['module' => 'Staffs', 'permission_name' => 'staffs.create'],
            ['module' => 'Staffs', 'permission_name' => 'staffs.edit'],
            ['module' => 'Staffs', 'permission_name' => 'staffs.delete'],

            // Roles
            ['module' => 'Roles', 'permission_name' => 'roles.view'],
            ['module' => 'Roles', 'permission_name' => 'roles.create'],
            ['module' => 'Roles', 'permission_name' => 'roles.edit'],
            ['module' => 'Roles', 'permission_name' => 'roles.delete'],

            // CMS
            ['module' => 'CMS', 'permission_name' => 'cms.view'],
            ['module' => 'CMS', 'permission_name' => 'cms.create'],
            ['module' => 'CMS', 'permission_name' => 'cms.edit'],
            ['module' => 'CMS', 'permission_name' => 'cms.delete'],

            // Profile
            ['module' => 'Profile', 'permission_name' => 'profile.view'],
            ['module' => 'Profile', 'permission_name' => 'profile.edit'],

            // System
            ['module' => 'System', 'permission_name' => 'System.view'],
            ['module' => 'System', 'permission_name' => 'settings.action'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['permission_name' => $permission['permission_name']],
                ['module' => $permission['module']]
            );
        }
    }
}