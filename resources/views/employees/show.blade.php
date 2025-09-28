<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employee Details') }} - {{ $employee->first_name }} {{ $employee->last_name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('employees.edit', $employee) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Employee
                </a>
                <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Employees
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Employee Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-white text-xl font-bold">
                                        {{ strtoupper(substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                                    <p class="text-gray-600">{{ $employee->position->title ?? 'No Position' }}</p>
                                    <p class="text-sm text-gray-500">{{ $employee->department->name ?? 'No Department' }}</p>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Employee ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->employee_id }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->email }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->phone ?? 'Not provided' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->date_of_birth?->format('M d, Y') ?? 'Not provided' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($employee->gender) ?? 'Not specified' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Employment Status</dt>
                                        <dd class="mt-1">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($employee->employment_status === 'active') bg-green-100 text-green-800
                                                @elseif($employee->employment_status === 'inactive') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($employee->employment_status) }}
                                            </span>
                                        </dd>
                                    </div>
                                </div>
                                @if($employee->address)
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->address }}</dd>
                                    </div>
                                @endif
                            </div>

                            <!-- Employment Information -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Employment Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->hire_date?->format('M d, Y') ?? 'Not provided' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->department->name ?? 'No Department' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Position</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->position->title ?? 'No Position' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Basic Salary</dt>
                                        <dd class="mt-1 text-sm text-gray-900">${{ number_format($employee->basic_salary, 2) }}</dd>
                                    </div>
                                </div>
                                @if($employee->termination_date)
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Termination Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->termination_date->format('M d, Y') }}</dd>
                                    </div>
                                @endif
                            </div>

                            <!-- Emergency Contact -->
                            @if($employee->emergency_contact || $employee->emergency_phone)
                                <div class="border-b border-gray-200 pb-6 mb-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if($employee->emergency_contact)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Contact Name</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $employee->emergency_contact }}</dd>
                                            </div>
                                        @endif
                                        @if($employee->emergency_phone)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Contact Phone</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $employee->emergency_phone }}</dd>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Banking Information -->
                            @if($employee->bank_name || $employee->bank_account || $employee->tax_id)
                                <div class="pb-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Banking Information</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @if($employee->bank_name)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Bank Name</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $employee->bank_name }}</dd>
                                            </div>
                                        @endif
                                        @if($employee->bank_account)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Account Number</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $employee->bank_account }}</dd>
                                            </div>
                                        @endif
                                        @if($employee->tax_id)
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tax ID</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $employee->tax_id }}</dd>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
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
                                <a href="{{ route('attendance.index', ['employee_id' => $employee->id]) }}" 
                                   class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    View Attendance
                                </a>
                                <a href="{{ route('payrolls.index', ['employee_id' => $employee->id]) }}" 
                                   class="block w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    View Payroll History
                                </a>
                                @if($employee->user)
                                    <a href="#" 
                                       class="block w-full text-center bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                        View User Account
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h4>
                            <div class="space-y-3">
                                <div class="text-sm text-gray-600">
                                    <p>Employee created on {{ $employee->created_at->format('M d, Y') }}</p>
                                </div>
                                @if($employee->updated_at != $employee->created_at)
                                    <div class="text-sm text-gray-600">
                                        <p>Last updated on {{ $employee->updated_at->format('M d, Y') }}</p>
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
