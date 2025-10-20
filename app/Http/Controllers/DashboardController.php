<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\PayrollPeriod;
use App\Models\PayrollRecord;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with key metrics.
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_employees' => Employee::active()->count(),
            'total_departments' => Department::active()->count(),
            'current_payroll_period' => PayrollPeriod::where('status', 'processing')->first(),
            'pending_payrolls' => PayrollRecord::where('status', 'draft')->count(),
            'approved_payrolls' => PayrollRecord::where('status', 'approved')->count(),
            'total_payroll_amount' => PayrollRecord::where('status', 'approved')->sum('net_salary'),
        ];

        // Recent payroll periods (admin/hr see global, employee sees none or own context)
        if ($user && $user->hasAnyRole(['admin', 'hr'])) {
            $recentPayrollPeriods = PayrollPeriod::with('creator')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            $recentPayrollPeriods = collect();
        }

        // Employee-specific payroll history (for employee role)
        $myPayrollHistory = collect();
        if ($user && $user->hasRole('employee') && $user->employee) {
            $myPayrollHistory = PayrollRecord::with('payrollPeriod')
                ->where('employee_id', $user->employee->id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Department-wise employee count
        $departmentStats = Department::withCount('employees')
            ->active()
            ->get();

        // Monthly payroll trend (last 6 months)
        $monthlyTrend = PayrollRecord::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(net_salary) as total_amount')
            )
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Recent attendance (today)
        $todayAttendance = AttendanceRecord::with('employee')
            ->whereDate('date', today())
            ->get()
            ->groupBy('status');

        return view('dashboard', compact(
            'stats',
            'recentPayrollPeriods',
            'departmentStats',
            'monthlyTrend',
            'todayAttendance',
            'myPayrollHistory'
        ));
    }

    /**
     * Get system health information
     */
    public function health()
    {
        $health = [
            'database' => $this->checkDatabaseConnection(),
            'employees_without_users' => Employee::whereNull('user_id')->count(),
            'users_without_employees' => \App\Models\User::whereDoesntHave('employee')->count(),
            'departments_without_positions' => Department::whereDoesntHave('positions')->count(),
            'recent_errors' => $this->getRecentErrors(),
        ];

        return response()->json($health);
    }

    /**
     * Check database connection
     */
    private function checkDatabaseConnection(): bool
    {
        try {
            \DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get recent system errors (placeholder)
     */
    private function getRecentErrors(): int
    {
        // This could be expanded to check log files or error tracking
        return 0;
    }
}
