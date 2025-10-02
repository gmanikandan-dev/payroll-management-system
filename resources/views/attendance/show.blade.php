<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Attendance Details') }} - {{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('attendance.edit', $attendance) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Attendance
                </a>
                <a href="{{ route('attendance.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Attendance
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Attendance Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white text-xl font-bold">
                                        {{ strtoupper(substr($attendance->employee->first_name, 0, 1) . substr($attendance->employee->last_name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $attendance->employee->first_name }} {{ $attendance->employee->last_name }}</h3>
                                    <p class="text-gray-600">{{ $attendance->employee->employee_id }}</p>
                                    <p class="text-sm text-gray-500">{{ $attendance->employee->position->title ?? 'No Position' }} - {{ $attendance->employee->department->name ?? 'No Department' }}</p>
                                </div>
                            </div>

                            <!-- Attendance Details -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Attendance Details</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attendance->date?->format('M d, Y') ?? 'Not set' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($attendance->status === 'present') bg-green-100 text-green-800
                                                @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                                                @elseif($attendance->status === 'late') bg-yellow-100 text-yellow-800
                                                @elseif($attendance->status === 'half_day') bg-orange-100 text-orange-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                            </span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Check In Time</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attendance->check_in?->format('h:i A') ?? 'Not recorded' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Check Out Time</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attendance->check_out?->format('h:i A') ?? 'Not recorded' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Hours Worked</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attendance->hours_worked ?? '0' }} hours</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Overtime Hours</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attendance->overtime_hours ?? '0' }} hours</dd>
                                    </div>
                                </div>
                                @if($attendance->notes)
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $attendance->notes }}</dd>
                                    </div>
                                @endif
                            </div>

                            <!-- Time Summary -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Regular Hours</p>
                                            <p class="text-2xl font-semibold text-gray-900">{{ $attendance->hours_worked ?? '0' }}h</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-orange-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Overtime Hours</p>
                                            <p class="text-2xl font-semibold text-gray-900">{{ $attendance->overtime_hours ?? '0' }}h</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h4>
                            <div class="space-y-3">
                                <a href="{{ route('employees.show', $attendance->employee) }}" 
                                   class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    View Employee Profile
                                </a>
                                <a href="{{ route('attendance.index', ['employee_id' => $attendance->employee_id]) }}" 
                                   class="block w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    View All Attendance
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Employee Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h4>
                            <div class="space-y-3">
                                <div class="text-sm">
                                    <dt class="font-medium text-gray-500">Employee ID</dt>
                                    <dd class="text-gray-900">{{ $attendance->employee->employee_id }}</dd>
                                </div>
                                <div class="text-sm">
                                    <dt class="font-medium text-gray-500">Department</dt>
                                    <dd class="text-gray-900">{{ $attendance->employee->department->name ?? 'No Department' }}</dd>
                                </div>
                                <div class="text-sm">
                                    <dt class="font-medium text-gray-500">Position</dt>
                                    <dd class="text-gray-900">{{ $attendance->employee->position->title ?? 'No Position' }}</dd>
                                </div>
                                <div class="text-sm">
                                    <dt class="font-medium text-gray-500">Employment Status</dt>
                                    <dd class="text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($attendance->employee->employment_status === 'active') bg-green-100 text-green-800
                                            @elseif($attendance->employee->employment_status === 'inactive') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($attendance->employee->employment_status) }}
                                        </span>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Attendance Information</h4>
                            <div class="space-y-3">
                                <div class="text-sm">
                                    <dt class="font-medium text-gray-500">Recorded</dt>
                                    <dd class="text-gray-900">{{ $attendance->created_at->format('M d, Y h:i A') }}</dd>
                                </div>
                                @if($attendance->updated_at != $attendance->created_at)
                                    <div class="text-sm">
                                        <dt class="font-medium text-gray-500">Last Updated</dt>
                                        <dd class="text-gray-900">{{ $attendance->updated_at->format('M d, Y h:i A') }}</dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

