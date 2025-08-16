<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Request Ferry Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Booking Information -->
            <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 p-4">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">Your Hotel Booking</h3>
                <p class="text-blue-700 dark:text-blue-300">
                    <strong>Room:</strong> {{ $booking->room->name }} | 
                    <strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y') }} | 
                    <strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y') }}
                </p>
            </div>

            <!-- Request Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Submit Ferry Ticket Request</h3>
                    
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-100 dark:bg-red-800/30 border border-red-200 dark:border-red-700 rounded-lg">
                            <div class="text-red-700 dark:text-red-300">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('ferry.submit-request') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Schedule Selection -->
                        <div>
                            <label for="ferry_schedule_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Select Ferry Schedule *
                            </label>
                            <select name="ferry_schedule_id" id="ferry_schedule_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Choose a schedule...</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" 
                                        {{ request()->get('schedule') == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->departure_time->format('M d, Y \a\t g:i A') }} - 
                                        {{ $schedule->origin }} → {{ $schedule->destination }} 
                                        ({{ $schedule->remaining_capacity }} seats available)
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Select your preferred departure time and route
                            </p>
                        </div>

                        <!-- Quantity Selection -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Number of Tickets *
                            </label>
                            <select name="quantity" id="quantity" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select quantity...</option>
                                <option value="1">1 ticket - $25.00</option>
                                <option value="2">2 tickets - $50.00</option>
                                <option value="3">3 tickets - $75.00</option>
                                <option value="4">4 tickets - $100.00</option>
                                <option value="5">5 tickets - $125.00</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Maximum 5 tickets per request
                            </p>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Additional Notes (Optional)
                            </label>
                            <textarea name="notes" id="notes" rows="3" maxlength="500"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Any special requirements or additional information..."></textarea>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Maximum 500 characters. This information will be shared with ferry operators.
                            </p>
                        </div>

                        <!-- Price Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Pricing Information</h4>
                            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex justify-between">
                                    <span>Price per ticket:</span>
                                    <span class="font-medium">$25.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Maximum tickets per request:</span>
                                    <span class="font-medium">5</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total cost will be calculated based on quantity</span>
                                </div>
                            </div>
                        </div>

                        <!-- Request Process Information -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">How the Request Process Works</h4>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300 space-y-1">
                                        <p>1. <strong>Submit Request:</strong> Fill out this form and submit your request</p>
                                        <p>2. <strong>Review Process:</strong> Ferry operators will review your request and validate your hotel booking</p>
                                        <p>3. <strong>Approval/Denial:</strong> You'll receive notification of the decision</p>
                                        <p>4. <strong>Ticket Issuance:</strong> If approved, tickets will be created and assigned to your booking</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-700 p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Important Information</h4>
                                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300 space-y-2">
                                        <p>• <strong>Valid Hotel Booking Required:</strong> You must have an active hotel booking to request ferry tickets</p>
                                        <p>• <strong>Request Review:</strong> All requests are reviewed by ferry operators before approval</p>
                                        <p>• <strong>No Immediate Purchase:</strong> This is a request, not an immediate purchase</p>
                                        <p>• <strong>Response Time:</strong> Requests are typically reviewed within 24 hours</p>
                                        <p>• <strong>Capacity Dependent:</strong> Approval depends on ferry schedule availability</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('visitor.ferry.schedules') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Schedules
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Available Schedules Summary -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Available Schedules</h3>
                    
                    @if($schedules->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($schedules->take(4) as $schedule)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-3">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                            {{ $schedule->departure_time->format('M d, g:i A') }}
                                        </h4>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $schedule->remaining_capacity }} seats
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $schedule->origin }} → {{ $schedule->destination }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        
                                                           @if($schedules->count() > 4)
                                       <div class="mt-4 text-center">
                                           <a href="{{ route('visitor.ferry.schedules') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                                               View all {{ $schedules->count() }} schedules →
                                           </a>
                                       </div>
                                   @endif
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No schedules available at the moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
