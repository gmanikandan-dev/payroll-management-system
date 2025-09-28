<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $hrRole = Role::where('slug', 'hr')->first();
        $employeeRole = Role::where('slug', 'employee')->first();

        // Admin gets all permissions
        $adminRole->permissions()->sync(Permission::pluck('id'));

        // HR permissions
        $hrPermissions = Permission::whereIn('slug', [
            'dashboard.view',
            'employees.view',
            'employees.create',
            'employees.edit',
            'departments.view',
            'departments.create',
            'departments.edit',
            'payrolls.view',
            'payrolls.create',
            'payrolls.process',
            'payrolls.approve',
            'attendance.view',
            'attendance.create',
            'attendance.edit',
            'attendance.bulk_import',
        ])->pluck('id');
        $hrRole->permissions()->sync($hrPermissions);

        // Employee permissions
        $employeePermissions = Permission::whereIn('slug', [
            'dashboard.view',
            'employees.view', // Can view own profile
            'attendance.view', // Can view own attendance
        ])->pluck('id');
        $employeeRole->permissions()->sync($employeePermissions);
    }
}
