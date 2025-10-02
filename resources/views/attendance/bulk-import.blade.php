<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bulk Import Attendance') }}
            </h2>
            <a href="{{ route('attendance.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Attendance
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Import Attendance Records</h3>
                        <p class="text-sm text-gray-600">
                            Upload a CSV file to import multiple attendance records at once. 
                            The file should contain employee data and attendance information.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('attendance.process-bulk-import') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Attendance Date</label>
                            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            @error('date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="attendance_data" class="block text-sm font-medium text-gray-700">Attendance Data</label>
                            <textarea name="attendance_data" id="attendance_data" rows="10" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                      placeholder="Enter attendance data in JSON format...">{{ old('attendance_data') }}</textarea>
                            <p class="mt-2 text-sm text-gray-500">
                                Enter attendance data in JSON format. Example:
                                <br>
                                <code class="text-xs bg-gray-100 p-2 rounded block mt-2">
                                    [<br>
                                    &nbsp;&nbsp;{<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;"employee_id": 1,<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;"status": "present",<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;"check_in": "09:00",<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;"check_out": "17:00",<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;"notes": "Regular day"<br>
                                    &nbsp;&nbsp;}<br>
                                    ]
                                </code>
                            </p>
                            @error('attendance_data')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('attendance.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Import Attendance
                            </button>
                        </div>
                    </form>

                    <!-- Instructions -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Import Instructions</h4>
                        <div class="text-sm text-gray-600 space-y-2">
                            <p><strong>Status Options:</strong> present, absent, late, half_day, on_leave</p>
                            <p><strong>Time Format:</strong> Use 24-hour format (HH:MM) for check_in and check_out</p>
                            <p><strong>Employee ID:</strong> Use the actual employee ID from the database</p>
                            <p><strong>Notes:</strong> Optional field for additional information</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
