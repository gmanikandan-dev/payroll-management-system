<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first department and position for demo purposes
        $department = \App\Models\Department::first();
        $position = \App\Models\Position::first();

        if (!$department || !$position) {
            $this->command->error('No department or position found. Please run DepartmentSeeder and PositionSeeder first.');
            return;
        }

        // Create employee record for admin user
        $adminUser = User::where('email', 'admin@payroll.com')->first();
        if ($adminUser && !$adminUser->employee) {
            Employee::create([
                'employee_id' => 'EMP001',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@payroll.com',
                'phone' => '+1234567890',
                'hire_date' => now()->subYear(),
                'position_id' => $position->id,
                'department_id' => $department->id,
                'user_id' => $adminUser->id,
                'employment_status' => 'active',
                'basic_salary' => 80000.00,
            ]);
            $this->command->info('Created employee record for Admin User');
        }

        // Create employee record for HR user
        $hrUser = User::where('email', 'hr@payroll.com')->first();
        if ($hrUser && !$hrUser->employee) {
            Employee::create([
                'employee_id' => 'EMP002',
                'first_name' => 'HR',
                'last_name' => 'Manager',
                'email' => 'hr@payroll.com',
                'phone' => '+1234567891',
                'hire_date' => now()->subMonths(6),
                'position_id' => $position->id,
                'department_id' => $department->id,
                'user_id' => $hrUser->id,
                'employment_status' => 'active',
                'basic_salary' => 70000.00,
            ]);
            $this->command->info('Created employee record for HR Manager');
        }

        // Create employee record for employee user
        $employeeUser = User::where('email', 'employee@payroll.com')->first();
        if ($employeeUser && !$employeeUser->employee) {
            Employee::create([
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
            $this->command->info('Created employee record for John Employee');
        }
    }
}
