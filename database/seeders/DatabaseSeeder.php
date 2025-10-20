<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users first
        $this->createUsers();

        // Run seeders in correct order
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            EmployeeRecordSeeder::class,
            AttendanceSeeder::class,
        ]);

        // Assign roles to users after roles are created
        $this->assignRolesToUsers();
    }

    /**
     * Create default users for the system
     */
    private function createUsers(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@payroll.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@payroll.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create HR User
        User::firstOrCreate(
            ['email' => 'hr@payroll.com'],
            [
                'name' => 'HR Manager',
                'email' => 'hr@payroll.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create Employee User
        User::firstOrCreate(
            ['email' => 'employee@payroll.com'],
            [
                'name' => 'John Employee',
                'email' => 'employee@payroll.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }

    /**
     * Assign roles to users
     */
    private function assignRolesToUsers(): void
    {
        $adminUser = User::where('email', 'admin@payroll.com')->first();
        $hrUser = User::where('email', 'hr@payroll.com')->first();
        $employeeUser = User::where('email', 'employee@payroll.com')->first();

        if ($adminUser) {
            $adminRole = Role::where('slug', 'admin')->first();
            if ($adminRole && ! $adminUser->roles()->where('role_id', $adminRole->id)->exists()) {
                $adminUser->roles()->attach($adminRole->id);
            }
        }

        if ($hrUser) {
            $hrRole = Role::where('slug', 'hr')->first();
            if ($hrRole && ! $hrUser->roles()->where('role_id', $hrRole->id)->exists()) {
                $hrUser->roles()->attach($hrRole->id);
            }
        }

        if ($employeeUser) {
            $employeeRole = Role::where('slug', 'employee')->first();
            if ($employeeRole && ! $employeeUser->roles()->where('role_id', $employeeRole->id)->exists()) {
                $employeeUser->roles()->attach($employeeRole->id);
            }
        }
    }
}
