<?php

namespace App\Http\Controllers;

use App\Models\PayrollPeriod;
use App\Models\PayrollRecord;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payrollPeriods = PayrollPeriod::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('payrolls.index', compact('payrollPeriods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payrolls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pay_date' => 'required|date|after:end_date',
            'notes' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';

        $payrollPeriod = PayrollPeriod::create($validated);

        return redirect()->route('payrolls.show', $payrollPeriod)
            ->with('success', 'Payroll period created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PayrollPeriod $payroll)
    {
        $payroll->load(['payrollRecords.employee', 'creator']);
        
        $stats = [
            'total_employees' => $payroll->payrollRecords->count(),
            'total_gross' => $payroll->payrollRecords->sum('gross_salary'),
            'total_net' => $payroll->payrollRecords->sum('net_salary'),
            'total_deductions' => $payroll->payrollRecords->sum('total_deductions'),
        ];

        return view('payrolls.show', compact('payroll', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PayrollPeriod $payroll)
    {
        return view('payrolls.edit', compact('payroll'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PayrollPeriod $payroll)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pay_date' => 'required|date|after:end_date',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,processing,completed,cancelled',
        ]);

        $payroll->update($validated);

        return redirect()->route('payrolls.show', $payroll)
            ->with('success', 'Payroll period updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayrollPeriod $payroll)
    {
        if ($payroll->status === 'completed') {
            return redirect()->route('payrolls.index')
                ->with('error', 'Cannot delete completed payroll period.');
        }

        $payroll->delete();

        return redirect()->route('payrolls.index')
            ->with('success', 'Payroll period deleted successfully.');
    }

    /**
     * Process payroll for a period.
     */
    public function process(PayrollPeriod $payroll)
    {
        if ($payroll->status !== 'draft') {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Only draft payroll periods can be processed.');
        }

        // Check if payroll period has valid dates
        if ($payroll->start_date >= $payroll->end_date) {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Payroll period must have valid start and end dates.');
        }

        try {
            DB::transaction(function () use ($payroll) {
                // Get all active employees
                $employees = Employee::active()->get();

                if ($employees->isEmpty()) {
                    throw new \Exception('No active employees found to process payroll.');
                }

            foreach ($employees as $employee) {
                // Calculate attendance for the period
                $attendance = $employee->attendanceRecords()
                    ->whereBetween('date', [$payroll->start_date, $payroll->end_date])
                    ->get();

                $workingDays = $attendance->where('status', 'present')->count();
                $totalDays = $payroll->start_date->diffInDays($payroll->end_date) + 1;
                $absentDays = $totalDays - $workingDays;

                // Calculate overtime
                $overtimeHours = $attendance->sum('overtime_hours');
                $overtimeRate = $employee->basic_salary / 160; // Assuming 160 hours per month
                $overtimeAmount = $overtimeHours * $overtimeRate;

                // Calculate basic salary (prorated for working days)
                $dailyRate = $employee->basic_salary / $totalDays;
                $basicSalary = $dailyRate * $workingDays;

                // Calculate gross salary
                $grossSalary = $basicSalary + $overtimeAmount;

                // Calculate deductions (simplified)
                $taxDeduction = $grossSalary * 0.1; // 10% tax
                $totalDeductions = $taxDeduction;

                // Calculate net salary
                $netSalary = $grossSalary - $totalDeductions;

                // Create payroll record
                PayrollRecord::create([
                    'payroll_period_id' => $payroll->id,
                    'employee_id' => $employee->id,
                    'basic_salary' => $basicSalary,
                    'total_allowances' => 0,
                    'total_deductions' => $totalDeductions,
                    'gross_salary' => $grossSalary,
                    'net_salary' => $netSalary,
                    'working_days' => $totalDays,
                    'present_days' => $workingDays,
                    'absent_days' => $absentDays,
                    'overtime_hours' => $overtimeHours,
                    'overtime_amount' => $overtimeAmount,
                    'status' => 'draft',
                ]);
            }

                // Update payroll period status
                $payroll->update(['status' => 'processing']);
            });

            return redirect()->route('payrolls.show', $payroll)
                ->with('success', 'Payroll processed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Failed to process payroll: ' . $e->getMessage());
        }
    }

    /**
     * Approve payroll for a period.
     */
    public function approve(PayrollPeriod $payroll)
    {
        if ($payroll->status !== 'processing') {
            return redirect()->route('payrolls.show', $payroll)
                ->with('error', 'Only processing payroll periods can be approved.');
        }

        DB::transaction(function () use ($payroll) {
            // Update all payroll records to approved
            $payroll->payrollRecords()->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Update payroll period status
            $payroll->update(['status' => 'completed']);
        });

        return redirect()->route('payrolls.show', $payroll)
            ->with('success', 'Payroll approved successfully.');
    }
}
