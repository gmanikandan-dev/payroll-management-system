<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['department', 'position']);

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by employment status
        if ($request->filled('employment_status')) {
            $query->where('employment_status', $request->employment_status);
        }

        // Search by name or employee ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(15);
        $departments = Department::active()->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::active()->get();
        $positions = Position::active()->get();

        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'basic_salary' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
        ]);

        // Generate unique employee ID
        $validated['employee_id'] = 'EMP' . strtoupper(Str::random(6));
        $validated['employment_status'] = 'active';

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['department', 'position', 'salaryStructures', 'payrollRecords.payrollPeriod']);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::active()->get();
        $positions = Position::active()->get();

        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
            'termination_date' => 'nullable|date|after:hire_date',
            'position_id' => 'required|exists:positions,id',
            'department_id' => 'required|exists:departments,id',
            'employment_status' => 'required|in:active,inactive,terminated,on_leave',
            'basic_salary' => 'required|numeric|min:0',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:255',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->update(['employment_status' => 'terminated']);

        return redirect()->route('employees.index')
            ->with('success', 'Employee terminated successfully.');
    }

    /**
     * Show the employee's own profile (self-service)
     */
    public function myProfile()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            return redirect()->route('dashboard')
                ->with('error', 'No employee record found for your account.');
        }

        $employee->load(['department', 'position', 'salaryStructures', 'payrollRecords.payrollPeriod']);

        return view('employees.show', compact('employee'));
    }
}
