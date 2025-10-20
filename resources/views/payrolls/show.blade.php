<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payroll Period Details') }} - {{ $payroll->name }}
            </h2>
            <div class="flex space-x-2">
                @perm('payrolls.edit')
                <a href="{{ route('payrolls.edit', $payroll) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Payroll
                </a>
                @endperm
                @perm('payrolls.view')
                <a href="{{ route('payrolls.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Payrolls
                </a>
                @endperm
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Payroll Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $payroll->name }}</h3>
                                    <p class="text-gray-600">{{ $payroll->start_date?->format('M d, Y') }} - {{ $payroll->end_date?->format('M d, Y') }}</p>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($payroll->status === 'completed') bg-green-100 text-green-800
                                        @elseif($payroll->status === 'processing') bg-yellow-100 text-yellow-800
                                        @elseif($payroll->status === 'draft') bg-gray-100 text-gray-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($payroll->status) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Payroll Details -->
                            <div class="border-b border-gray-200 pb-6 mb-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Payroll Details</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $payroll->start_date?->format('M d, Y') ?? 'Not set' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">End Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $payroll->end_date?->format('M d, Y') ?? 'Not set' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Pay Date</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $payroll->pay_date?->format('M d, Y') ?? 'Not set' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $payroll->creator->name ?? 'Unknown' }}</dd>
                                    </div>
                                </div>
                                @if($payroll->notes)
                                    <div class="mt-4">
                                        <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $payroll->notes }}</dd>
                                    </div>
                                @endif
                            </div>

                            <!-- Payroll Statistics -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Total Employees</p>
                                            <p class="text-2xl font-semibold text-gray-900">{{ $payroll->payrollRecords->count() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-green-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Total Gross</p>
                                            <p class="text-2xl font-semibold text-gray-900">${{ number_format($payroll->payrollRecords->sum('gross_salary'), 2) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-500">Total Net</p>
                                            <p class="text-2xl font-semibold text-gray-900">${{ number_format($payroll->payrollRecords->sum('net_salary'), 2) }}</p>
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
                                @if($payroll->status === 'draft')
                                    @perm('payrolls.process')
                                    <form method="POST" action="{{ route('payrolls.process', $payroll) }}" class="inline-block w-full">
                                        @csrf
                                        <button type="submit" class="block w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Process Payroll
                                        </button>
                                    </form>
                                    @endperm
                                @endif
                                
                                @if($payroll->status === 'processing')
                                    @perm('payrolls.approve')
                                    <form method="POST" action="{{ route('payrolls.approve', $payroll) }}" class="inline-block w-full">
                                        @csrf
                                        <button type="submit" class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Approve Payroll
                                        </button>
                                    </form>
                                    @endperm
                                @endif
                                
                                @perm('attendance.view')
                                <a href="{{ route('attendance.index', ['payroll_period_id' => $payroll->id]) }}" 
                                   class="block w-full text-center bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    View Attendance
                                </a>
                                @endperm
                            </div>
                        </div>
                    </div>

                    <!-- Payroll Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Payroll Information</h4>
                            <div class="space-y-3">
                                <div class="text-sm">
                                    <dt class="font-medium text-gray-500">Created</dt>
                                    <dd class="text-gray-900">{{ $payroll->created_at->format('M d, Y') }}</dd>
                                </div>
                                @if($payroll->updated_at != $payroll->created_at)
                                    <div class="text-sm">
                                        <dt class="font-medium text-gray-500">Last Updated</dt>
                                        <dd class="text-gray-900">{{ $payroll->updated_at->format('M d, Y') }}</dd>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payroll Records -->
            @if($payroll->payrollRecords->count() > 0)
                <div class="mt-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Payroll Records</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Basic Salary</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allowances</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deductions</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gross Salary</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Salary</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($payroll->payrollRecords as $record)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                            <span class="text-white text-xs font-bold">
                                                                {{ strtoupper(substr($record->employee->first_name, 0, 1) . substr($record->employee->last_name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $record->employee->first_name }} {{ $record->employee->last_name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $record->employee->employee_id }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($record->basic_salary, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($record->total_allowances, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($record->total_deductions, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($record->gross_salary, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($record->net_salary, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($record->status === 'paid') bg-green-100 text-green-800
                                                        @elseif($record->status === 'approved') bg-blue-100 text-blue-800
                                                        @else bg-yellow-100 text-yellow-800
                                                        @endif">
                                                        {{ ucfirst($record->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

