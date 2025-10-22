<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AttendanceRecord::with('employee');

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendanceRecords = $query->orderBy('date', 'desc')
            ->orderBy('employee_id')
            ->paginate(20);

        $employees = Employee::active()->orderBy('first_name')->get();

        return view('attendance.index', compact('attendanceRecords', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = Carbon::today();

        // If employee role, restrict to own employee record
        $currentUser = Auth::id() ? User::with(['roles', 'employee'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists() && $currentUser->employee) {
            $employees = collect([$currentUser->employee]);
        } else {
            $employees = Employee::active()->orderBy('first_name')->get();
        }

        return view('attendance.create', compact('employees', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,half_day,on_leave',
            'notes' => 'nullable|string',
        ]);

        // Ownership enforcement: employees can only create for themselves
        $currentUser = Auth::id() ? User::with(['roles', 'employee'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists()) {
            if (!$currentUser->employee || (int)$validated['employee_id'] !== (int)$currentUser->employee->id) {
                abort(403, 'Unauthorized: you can only create your own attendance.');
            }
        }

        // Check if attendance record already exists for this employee and date
        $existingRecord = AttendanceRecord::where('employee_id', $validated['employee_id'])
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existingRecord) {
            return redirect()->back()
                ->with('error', 'Attendance record already exists for this employee on this date.')
                ->withInput();
        }

        // Calculate hours worked if check-in and check-out are provided
        if ($validated['check_in'] && $validated['check_out']) {
            $checkIn = Carbon::createFromFormat('H:i', $validated['check_in']);
            $checkOut = Carbon::createFromFormat('H:i', $validated['check_out']);
            $hoursWorked = $checkOut->diffInHours($checkIn);
            
            // Calculate overtime (assuming 8 hours is standard)
            $overtimeHours = max(0, $hoursWorked - 8);
            
            $validated['hours_worked'] = $hoursWorked;
            $validated['overtime_hours'] = $overtimeHours;
        }

        AttendanceRecord::create($validated);

        // Redirect based on user role
        $currentUser = Auth::id() ? User::with(['roles'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists()) {
            return redirect()->route('my.attendance')
                ->with('success', 'Attendance record created successfully.');
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AttendanceRecord $attendance)
    {
        $attendance->load('employee');
        
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceRecord $attendance)
    {
        $currentUser = Auth::id() ? User::with(['roles', 'employee'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists()) {
            if (!$currentUser->employee || $attendance->employee_id !== $currentUser->employee->id) {
                abort(403, 'Unauthorized: you can only edit your own attendance.');
            }
            // Limit selectable employees to self
            $employees = collect([$currentUser->employee]);
        } else {
            $employees = Employee::active()->orderBy('first_name')->get();
        }

        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceRecord $attendance)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,half_day,on_leave',
            'notes' => 'nullable|string',
        ]);

        // Ownership enforcement: employees can only update their own record
        $currentUser = Auth::id() ? User::with(['roles', 'employee'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists()) {
            if (!$currentUser->employee || $attendance->employee_id !== $currentUser->employee->id || (int)$validated['employee_id'] !== (int)$currentUser->employee->id) {
                abort(403, 'Unauthorized: you can only update your own attendance.');
            }
        }

        // Calculate hours worked if check-in and check-out are provided
        if ($validated['check_in'] && $validated['check_out']) {
            $checkIn = Carbon::createFromFormat('H:i', $validated['check_in']);
            $checkOut = Carbon::createFromFormat('H:i', $validated['check_out']);
            $hoursWorked = $checkOut->diffInHours($checkIn);
            
            // Calculate overtime (assuming 8 hours is standard)
            $overtimeHours = max(0, $hoursWorked - 8);
            
            $validated['hours_worked'] = $hoursWorked;
            $validated['overtime_hours'] = $overtimeHours;
        }

        $attendance->update($validated);

        // Redirect based on user role
        $currentUser = Auth::id() ? User::with(['roles'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists()) {
            return redirect()->route('my.attendance')
                ->with('success', 'Attendance record updated successfully.');
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceRecord $attendance)
    {
        $attendance->delete();

        // Redirect based on user role
        $currentUser = Auth::id() ? User::with(['roles'])->find(Auth::id()) : null;
        if ($currentUser && $currentUser->roles()->where('slug', 'employee')->exists()) {
            return redirect()->route('my.attendance')
                ->with('success', 'Attendance record deleted successfully.');
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Show bulk import form.
     */
    public function bulkImport()
    {
        $employees = Employee::active()->orderBy('first_name')->get();
        
        return view('attendance.bulk-import', compact('employees'));
    }

    /**
     * Process bulk import.
     */
    public function processBulkImport(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'attendance_data' => 'required|string',
        ]);

        // Parse JSON data
        $attendanceData = json_decode($validated['attendance_data'], true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()
                ->with('error', 'Invalid JSON format in attendance data.')
                ->withInput();
        }

        if (!is_array($attendanceData)) {
            return redirect()->back()
                ->with('error', 'Attendance data must be an array.')
                ->withInput();
        }

        // Validate each attendance record
        foreach ($attendanceData as $index => $data) {
            $validator = \Validator::make($data, [
                'employee_id' => 'required|exists:employees,id',
                'status' => 'required|in:present,absent,late,half_day,on_leave',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->with('error', "Validation error in record " . ($index + 1) . ": " . implode(', ', $validator->errors()->all()))
                    ->withInput();
            }
        }

        $imported = 0;
        $skipped = 0;

        foreach ($attendanceData as $data) {
            // Check if record already exists
            $existing = AttendanceRecord::where('employee_id', $data['employee_id'])
                ->whereDate('date', $validated['date'])
                ->first();

            if ($existing) {
                $skipped++;
                continue;
            }

            $attendanceData = [
                'employee_id' => $data['employee_id'],
                'date' => $validated['date'],
                'status' => $data['status'],
                'check_in' => $data['check_in'] ?? null,
                'check_out' => $data['check_out'] ?? null,
                'notes' => $data['notes'] ?? null,
            ];

            // Calculate hours if check-in and check-out provided
            if ($attendanceData['check_in'] && $attendanceData['check_out']) {
                $checkIn = Carbon::createFromFormat('H:i', $attendanceData['check_in']);
                $checkOut = Carbon::createFromFormat('H:i', $attendanceData['check_out']);
                $hoursWorked = $checkOut->diffInHours($checkIn);
                $overtimeHours = max(0, $hoursWorked - 8);
                
                $attendanceData['hours_worked'] = $hoursWorked;
                $attendanceData['overtime_hours'] = $overtimeHours;
            }

            AttendanceRecord::create($attendanceData);
            $imported++;
        }

        return redirect()->route('attendance.index')
            ->with('success', "Bulk import completed. {$imported} records imported, {$skipped} skipped.");
    }

    /**
     * Show the employee's own attendance records (self-service)
     */
    public function myAttendance(Request $request)
    {
        $employee = Auth::user()?->employee;
        
        if (!$employee) {
            return redirect()->route('dashboard')
                ->with('error', 'No employee record found for your account.');
        }

        $query = $employee->attendanceRecords()->orderBy('date', 'desc');

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendanceRecords = $query->paginate(20);

        // For employee self-service, we don't need the employees list for filtering
        $employees = collect();

        return view('attendance.index', compact('attendanceRecords', 'employees', 'employee'));
    }
}
