<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // HR Positions
            [
                'title' => 'HR Manager',
                'description' => 'Oversees all human resources activities and policies',
                'code' => 'HR-MGR',
                'department_id' => Department::where('code', 'HR')->first()->id,
                'min_salary' => 60000,
                'max_salary' => 80000,
                'is_active' => true,
            ],
            [
                'title' => 'HR Specialist',
                'description' => 'Handles recruitment and employee relations',
                'code' => 'HR-SPEC',
                'department_id' => Department::where('code', 'HR')->first()->id,
                'min_salary' => 40000,
                'max_salary' => 55000,
                'is_active' => true,
            ],

            // IT Positions
            [
                'title' => 'Software Developer',
                'description' => 'Develops and maintains software applications',
                'code' => 'IT-DEV',
                'department_id' => Department::where('code', 'IT')->first()->id,
                'min_salary' => 50000,
                'max_salary' => 75000,
                'is_active' => true,
            ],
            [
                'title' => 'System Administrator',
                'description' => 'Manages IT infrastructure and systems',
                'code' => 'IT-SYSADMIN',
                'department_id' => Department::where('code', 'IT')->first()->id,
                'min_salary' => 45000,
                'max_salary' => 65000,
                'is_active' => true,
            ],

            // Finance Positions
            [
                'title' => 'Finance Manager',
                'description' => 'Oversees financial planning and analysis',
                'code' => 'FIN-MGR',
                'department_id' => Department::where('code', 'FIN')->first()->id,
                'min_salary' => 65000,
                'max_salary' => 85000,
                'is_active' => true,
            ],
            [
                'title' => 'Accountant',
                'description' => 'Handles accounting and financial reporting',
                'code' => 'FIN-ACC',
                'department_id' => Department::where('code', 'FIN')->first()->id,
                'min_salary' => 35000,
                'max_salary' => 50000,
                'is_active' => true,
            ],

            // Marketing Positions
            [
                'title' => 'Marketing Manager',
                'description' => 'Develops and executes marketing strategies',
                'code' => 'MKT-MGR',
                'department_id' => Department::where('code', 'MKT')->first()->id,
                'min_salary' => 55000,
                'max_salary' => 75000,
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Specialist',
                'description' => 'Executes marketing campaigns and content creation',
                'code' => 'MKT-SPEC',
                'department_id' => Department::where('code', 'MKT')->first()->id,
                'min_salary' => 35000,
                'max_salary' => 50000,
                'is_active' => true,
            ],

            // Operations Positions
            [
                'title' => 'Operations Manager',
                'description' => 'Oversees daily operations and process improvement',
                'code' => 'OPS-MGR',
                'department_id' => Department::where('code', 'OPS')->first()->id,
                'min_salary' => 60000,
                'max_salary' => 80000,
                'is_active' => true,
            ],

            // Sales Positions
            [
                'title' => 'Sales Manager',
                'description' => 'Leads sales team and develops sales strategies',
                'code' => 'SALES-MGR',
                'department_id' => Department::where('code', 'SALES')->first()->id,
                'min_salary' => 50000,
                'max_salary' => 70000,
                'is_active' => true,
            ],
            [
                'title' => 'Sales Representative',
                'description' => 'Handles customer acquisition and sales',
                'code' => 'SALES-REP',
                'department_id' => Department::where('code', 'SALES')->first()->id,
                'min_salary' => 30000,
                'max_salary' => 45000,
                'is_active' => true,
            ],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
