<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@payroll.com',
        ]);

        // Assign admin role to admin user
        $adminRole = Role::where('slug', 'admin')->first();
        $adminUser->assignRole($adminRole);

        // Create HR user
        $hrUser = User::factory()->create([
            'name' => 'HR Manager',
            'email' => 'hr@payroll.com',
        ]);

        // Assign HR role to HR user
        $hrRole = Role::where('slug', 'hr')->first();
        $hrUser->assignRole($hrRole);

        // Create employee user
        $employeeUser = User::factory()->create([
            'name' => 'John Employee',
            'email' => 'employee@payroll.com',
        ]);

        // Assign employee role to employee user
        $employeeRole = Role::where('slug', 'employee')->first();
        $employeeUser->assignRole($employeeRole);

        // Seed departments and positions
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
        ]);
    }
}
