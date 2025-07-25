<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Edit Ferry Schedule">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Ferry Schedule</h1>
                    <p class="text-gray-600 mt-2">Update ferry departure schedule information</p>
                </div>
                <a href="{{ route('ferry.schedules') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Schedules
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('ferry.schedules.update', $schedule->id) }}" method="POST" id="scheduleForm" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <!-- Form Header -->
                <div class="px-8 py-6 border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Schedule Details
                    </h2>
                    <p class="text-gray-600 mt-1">Update the ferry schedule information below</p>
                </div>

                <div class="px-8 py-6 space-y-8">
                    <!-- Route Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Route Information
                            </h3>
                            
                            <!-- Origin -->
                            <div class="relative">
                                <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">
                                    Departure Location <span class="text-red-500">*</span>
                                </label>
                                <select name="origin" id="origin" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('origin') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Select departure location</option>
                                    <option value="Male International Airport" {{ old('origin', $schedule->origin) == 'Male International Airport' ? 'selected' : '' }}>Male International Airport</option>
                                    <option value="Paradise Resort" {{ old('origin', $schedule->origin) == 'Paradise Resort' ? 'selected' : '' }}>Paradise Resort</option>
                                </select>
                                @error('origin')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Destination -->
                            <div class="relative">
                                <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                                    Arrival Location <span class="text-red-500">*</span>
                                </label>
                                <select name="destination" id="destination" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('destination') border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Select arrival location</option>
                                    <option value="Male International Airport" {{ old('destination', $schedule->destination) == 'Male International Airport' ? 'selected' : '' }}>Male International Airport</option>
                                    <option value="Paradise Resort" {{ old('destination', $schedule->destination) == 'Paradise Resort' ? 'selected' : '' }}>Paradise Resort</option>
                                </select>
                                @error('destination')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Schedule & Ferry Details
                            </h3>
                            
                            <!-- Departure Time -->
                            <div class="relative">
                                <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Departure Date & Time <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="departure_time" id="departure_time" 
                                       value="{{ old('departure_time', $schedule->departure_time->format('Y-m-d\TH:i')) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('departure_time') border-red-500 focus:ring-red-500 @enderror">
                                @error('departure_time')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Seats Available -->
                            <div class="relative">
                                <label for="seats_available" class="block text-sm font-medium text-gray-700 mb-2">
                                    Available Seats <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="seats_available" id="seats_available" 
                                       value="{{ old('seats_available', $schedule->seats_available) }}" required min="1" max="200"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('seats_available') border-red-500 focus:ring-red-500 @enderror">
                                <p class="mt-1 text-sm text-gray-500">Maximum capacity: 200 passengers</p>
                                @error('seats_available')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <button type="submit" id="submitBtn"
                            class="inline-flex items-center px-8 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span id="submitText">Update Schedule</span>
                        <svg id="loadingIcon" class="hidden w-4 h-4 ml-2 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

    </x-sidebar>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('scheduleForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const loadingIcon = document.getElementById('loadingIcon');

        // Form submission handling
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitText.textContent = 'Updating...';
            loadingIcon.classList.remove('hidden');
            
            setTimeout(() => {
                if (!form.checkValidity()) {
                    submitBtn.disabled = false;
                    submitText.textContent = 'Update Schedule';
                    loadingIcon.classList.add('hidden');
                }
            }, 100);
        });

        // Form validation feedback
        const inputs = form.querySelectorAll('input[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                } else {
                    this.classList.remove('border-green-500');
                    this.classList.add('border-red-500');
                }
            });
        });

        // Prevent same origin/destination
        const originSelect = document.getElementById('origin');
        const destinationSelect = document.getElementById('destination');
        
        function validateRoute() {
            if (originSelect.value && destinationSelect.value && originSelect.value === destinationSelect.value) {
                destinationSelect.setCustomValidity('Destination must be different from origin');
                destinationSelect.classList.add('border-red-500');
            } else {
                destinationSelect.setCustomValidity('');
                destinationSelect.classList.remove('border-red-500');
            }
        }

        originSelect.addEventListener('change', validateRoute);
        destinationSelect.addEventListener('change', validateRoute);
    });
    </script>
</x-app-layout>