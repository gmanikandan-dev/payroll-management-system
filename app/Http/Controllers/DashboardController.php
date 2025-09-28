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
        $stats = [
            'total_employees' => Employee::active()->count(),
            'total_departments' => Department::active()->count(),
            'current_payroll_period' => PayrollPeriod::where('status', 'processing')->first(),
            'pending_payrolls' => PayrollRecord::where('status', 'draft')->count(),
            'approved_payrolls' => PayrollRecord::where('status', 'approved')->count(),
            'total_payroll_amount' => PayrollRecord::where('status', 'approved')
                ->sum('net_salary'),
        ];

        // Recent payroll periods
        $recentPayrollPeriods = PayrollPeriod::with('creator')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

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
            'todayAttendance'
        ));
    }
}
