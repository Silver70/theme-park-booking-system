<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Purchase Ferry Tickets') }}
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

            <!-- Purchase Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Purchase Ferry Tickets</h3>
                    
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

                    <form method="POST" action="{{ route('ferry.store-ticket') }}" class="space-y-6">
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
                                Maximum 5 tickets per purchase
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
                                    <span>Maximum tickets per purchase:</span>
                                    <span class="font-medium">5</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total cost will be calculated based on quantity</span>
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
                                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>You must have a valid hotel booking to purchase ferry tickets</li>
                                            <li>Tickets are non-refundable and non-transferable</li>
                                            <li>Please arrive at the ferry terminal 30 minutes before departure</li>
                                            <li>Ferry tickets are valid only for the selected schedule</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('ferry.schedules') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Schedules
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Purchase Tickets
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
                                <a href="{{ route('ferry.schedules') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
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
