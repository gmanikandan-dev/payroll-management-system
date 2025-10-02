<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard permissions
            [
                'name' => 'View Dashboard',
                'slug' => 'dashboard.view',
                'description' => 'Access to dashboard',
                'resource' => 'dashboard',
                'action' => 'view',
                'is_active' => true,
            ],

            // Employee permissions
            [
                'name' => 'View Employees',
                'slug' => 'employees.view',
                'description' => 'View employee list',
                'resource' => 'employees',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'Create Employees',
                'slug' => 'employees.create',
                'description' => 'Create new employees',
                'resource' => 'employees',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'Edit Employees',
                'slug' => 'employees.edit',
                'description' => 'Edit employee information',
                'resource' => 'employees',
                'action' => 'edit',
                'is_active' => true,
            ],
            [
                'name' => 'Delete Employees',
                'slug' => 'employees.delete',
                'description' => 'Delete employees',
                'resource' => 'employees',
                'action' => 'delete',
                'is_active' => true,
            ],

            // Department permissions
            [
                'name' => 'View Departments',
                'slug' => 'departments.view',
                'description' => 'View department list',
                'resource' => 'departments',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'Create Departments',
                'slug' => 'departments.create',
                'description' => 'Create new departments',
                'resource' => 'departments',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'Edit Departments',
                'slug' => 'departments.edit',
                'description' => 'Edit department information',
                'resource' => 'departments',
                'action' => 'edit',
                'is_active' => true,
            ],
            [
                'name' => 'Delete Departments',
                'slug' => 'departments.delete',
                'description' => 'Delete departments',
                'resource' => 'departments',
                'action' => 'delete',
                'is_active' => true,
            ],

            // Payroll permissions
            [
                'name' => 'View Payrolls',
                'slug' => 'payrolls.view',
                'description' => 'View payroll records',
                'resource' => 'payrolls',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'Create Payrolls',
                'slug' => 'payrolls.create',
                'description' => 'Create payroll periods',
                'resource' => 'payrolls',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'Process Payrolls',
                'slug' => 'payrolls.process',
                'description' => 'Process payroll calculations',
                'resource' => 'payrolls',
                'action' => 'process',
                'is_active' => true,
            ],
            [
                'name' => 'Approve Payrolls',
                'slug' => 'payrolls.approve',
                'description' => 'Approve payroll records',
                'resource' => 'payrolls',
                'action' => 'approve',
                'is_active' => true,
            ],

            // Attendance permissions
            [
                'name' => 'View Attendance',
                'slug' => 'attendance.view',
                'description' => 'View attendance records',
                'resource' => 'attendance',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'Create Attendance',
                'slug' => 'attendance.create',
                'description' => 'Create attendance records',
                'resource' => 'attendance',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'Edit Attendance',
                'slug' => 'attendance.edit',
                'description' => 'Edit attendance records',
                'resource' => 'attendance',
                'action' => 'edit',
                'is_active' => true,
            ],
            [
                'name' => 'Bulk Import Attendance',
                'slug' => 'attendance.bulk_import',
                'description' => 'Bulk import attendance records',
                'resource' => 'attendance',
                'action' => 'bulk_import',
                'is_active' => true,
            ],

            // User management permissions
            [
                'name' => 'View Users',
                'slug' => 'users.view',
                'description' => 'View user accounts',
                'resource' => 'users',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'Create Users',
                'slug' => 'users.create',
                'description' => 'Create user accounts',
                'resource' => 'users',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'Edit Users',
                'slug' => 'users.edit',
                'description' => 'Edit user accounts',
                'resource' => 'users',
                'action' => 'edit',
                'is_active' => true,
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'users.delete',
                'description' => 'Delete user accounts',
                'resource' => 'users',
                'action' => 'delete',
                'is_active' => true,
            ],

            // Role management permissions
            [
                'name' => 'View Roles',
                'slug' => 'roles.view',
                'description' => 'View roles and permissions',
                'resource' => 'roles',
                'action' => 'view',
                'is_active' => true,
            ],
            [
                'name' => 'Create Roles',
                'slug' => 'roles.create',
                'description' => 'Create roles and permissions',
                'resource' => 'roles',
                'action' => 'create',
                'is_active' => true,
            ],
            [
                'name' => 'Edit Roles',
                'slug' => 'roles.edit',
                'description' => 'Edit roles and permissions',
                'resource' => 'roles',
                'action' => 'edit',
                'is_active' => true,
            ],
            [
                'name' => 'Delete Roles',
                'slug' => 'roles.delete',
                'description' => 'Delete roles and permissions',
                'resource' => 'roles',
                'action' => 'delete',
                'is_active' => true,
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
