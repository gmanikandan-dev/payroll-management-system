<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full system access with all permissions',
                'is_active' => true,
            ],
            [
                'name' => 'Human Resources',
                'slug' => 'hr',
                'description' => 'HR management with employee and payroll access',
                'is_active' => true,
            ],
            [
                'name' => 'Employee',
                'slug' => 'employee',
                'description' => 'Basic employee access to view own records',
                'is_active' => true,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
