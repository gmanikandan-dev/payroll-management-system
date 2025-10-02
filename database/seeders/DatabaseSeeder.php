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

        // Create employee record for employee user
        $employeeUser = User::where('email', 'employee@payroll.com')->first();
        if ($employeeUser && !$employeeUser->employee) {
            \App\Models\Employee::create([
                'employee_id' => 'EMP003',
                'first_name' => 'John',
                'last_name' => 'Employee',
                'email' => 'employee@payroll.com',
                'phone' => '+1234567892',
                'hire_date' => now()->subMonths(3),
                'position_id' => $position->id,
                'department_id' => $department->id,
                'user_id' => $employeeUser->id,
                'employment_status' => 'active',
                'basic_salary' => 50000.00,
            ]);
        }
    }
}
