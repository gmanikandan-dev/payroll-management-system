<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Human Resources',
                'description' => 'Manages employee relations, recruitment, and HR policies',
                'code' => 'HR',
                'is_active' => true,
            ],
            [
                'name' => 'Information Technology',
                'description' => 'Handles software development, system administration, and technical support',
                'code' => 'IT',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'description' => 'Manages financial planning, accounting, and budget control',
                'code' => 'FIN',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'description' => 'Responsible for brand promotion, advertising, and market research',
                'code' => 'MKT',
                'is_active' => true,
            ],
            [
                'name' => 'Operations',
                'description' => 'Oversees daily business operations and process improvement',
                'code' => 'OPS',
                'is_active' => true,
            ],
            [
                'name' => 'Sales',
                'description' => 'Handles customer acquisition, sales strategies, and revenue generation',
                'code' => 'SALES',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
