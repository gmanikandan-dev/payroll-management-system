<?php

namespace Database\Seeders;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define users to create attendance records for
        $userEmails = [
            'admin@payroll.com',
            'hr@payroll.com', 
            'employee@payroll.com'
        ];

        $this->command->info('Creating attendance records for all users...');

        foreach ($userEmails as $email) {
            $this->createAttendanceForUser($email);
        }

        $this->command->info('All attendance records created successfully!');
    }

    /**
     * Create attendance records for a specific user
     */
    private function createAttendanceForUser(string $email): void
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->command->warn("User with email {$email} not found. Please run EmployeeRecordSeeder first.");
            return;
        }

        $employee = $user->employee;
        
        if (!$employee) {
            $this->command->warn("Employee record not found for user {$email}. Please run EmployeeRecordSeeder first.");
            return;
        }

        $this->command->info("Creating attendance records for: " . $employee->full_name);

        // Create attendance records for the previous 5 days (excluding weekends)
        $today = Carbon::now();
        $recordsCreated = 0;
        
        for ($i = 1; $i <= 5; $i++) {
            $date = $today->copy()->subDays($i);
            
            // Skip weekends (Saturday = 6, Sunday = 0)
            if ($date->dayOfWeek == 0 || $date->dayOfWeek == 6) {
                continue;
            }
            
            // Check if attendance record already exists for this date
            $existingRecord = AttendanceRecord::where('employee_id', $employee->id)
                ->where('date', $date->format('Y-m-d'))
                ->first();
                
            if ($existingRecord) {
                $this->command->info("  Attendance record already exists for {$date->format('Y-m-d')}");
                continue;
            }

            // Generate realistic check-in and check-out times based on role
            $checkIn = $this->generateCheckInTime($date, $email);
            $checkOut = $this->generateCheckOutTime($date, $email);
            
            // Calculate hours worked
            $hoursWorked = $checkOut->diffInHours($checkIn, true);
            
            // Determine status based on check-in time and role
            $status = $this->determineStatus($checkIn, $email);
            
            // Create attendance record
            AttendanceRecord::create([
                'employee_id' => $employee->id,
                'date' => $date->format('Y-m-d'),
                'check_in' => $checkIn->format('H:i:s'),
                'check_out' => $checkOut->format('H:i:s'),
                'hours_worked' => $hoursWorked,
                'overtime_hours' => max(0, $hoursWorked - 8), // Overtime if more than 8 hours
                'status' => $status,
                'notes' => $this->generateNotes($status, $email),
            ]);
            
            $this->command->info("  Created attendance record for {$date->format('Y-m-d')} - Status: {$status}");
            $recordsCreated++;
        }

        $this->command->info("  Total records created for {$employee->full_name}: {$recordsCreated}");
    }

    /**
     * Generate check-in time based on role
     */
    private function generateCheckInTime(Carbon $date, string $email): Carbon
    {
        switch ($email) {
            case 'admin@payroll.com':
                // Admin arrives early (7:30 AM - 8:00 AM)
                return $date->copy()->setTime(7, rand(30, 59), 0);
            case 'hr@payroll.com':
                // HR arrives on time (8:00 AM - 8:15 AM)
                return $date->copy()->setTime(8, rand(0, 15), 0);
            case 'employee@payroll.com':
                // Employee arrives slightly later (8:00 AM - 8:30 AM)
                return $date->copy()->setTime(8, rand(0, 30), 0);
            default:
                return $date->copy()->setTime(8, rand(0, 30), 0);
        }
    }

    /**
     * Generate check-out time based on role
     */
    private function generateCheckOutTime(Carbon $date, string $email): Carbon
    {
        switch ($email) {
            case 'admin@payroll.com':
                // Admin works longer hours (6:00 PM - 7:00 PM)
                return $date->copy()->setTime(18, rand(0, 59), 0);
            case 'hr@payroll.com':
                // HR works standard hours (5:00 PM - 5:30 PM)
                return $date->copy()->setTime(17, rand(0, 30), 0);
            case 'employee@payroll.com':
                // Employee works standard hours (5:00 PM - 5:30 PM)
                return $date->copy()->setTime(17, rand(0, 30), 0);
            default:
                return $date->copy()->setTime(17, rand(0, 30), 0);
        }
    }

    /**
     * Determine attendance status based on check-in time and role
     */
    private function determineStatus(Carbon $checkIn, string $email): string
    {
        // Admin is rarely late
        if ($email === 'admin@payroll.com') {
            return $checkIn->hour > 8 || ($checkIn->hour == 8 && $checkIn->minute > 10) ? 'late' : 'present';
        }
        
        // HR is occasionally late
        if ($email === 'hr@payroll.com') {
            return $checkIn->hour > 8 || ($checkIn->hour == 8 && $checkIn->minute > 15) ? 'late' : 'present';
        }
        
        // Employee can be late more often
        if ($email === 'employee@payroll.com') {
            return $checkIn->hour > 8 || ($checkIn->hour == 8 && $checkIn->minute > 20) ? 'late' : 'present';
        }
        
        return 'present';
    }

    /**
     * Generate notes based on status and role
     */
    private function generateNotes(string $status, string $email): ?string
    {
        if ($status !== 'late') {
            return null;
        }

        $notes = [
            'admin@payroll.com' => 'Late due to important meeting',
            'hr@payroll.com' => 'Late due to traffic',
            'employee@payroll.com' => 'Late due to traffic'
        ];

        return $notes[$email] ?? 'Arrived late';
    }
}
