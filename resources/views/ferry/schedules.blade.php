<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ferry Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Booking Information -->
            <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 p-4">
                <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2">Your Hotel Booking</h3>
                <p class="text-blue-700 dark:text-blue-300">
                    <strong>Room:</strong> {{ $booking->room->name }} | 
                    <strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y') }} | 
                    <strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y') }}
                </p>
                <div class="mt-2 p-2 bg-blue-100 dark:bg-blue-800/50 rounded text-sm text-blue-800 dark:text-blue-200">
                    <strong>Ferry Schedules Available:</strong> Showing schedules from {{ $booking->check_in_date->copy()->subDay()->format('M d') }} to {{ $booking->check_out_date->copy()->addDay()->format('M d, Y') }} 
                    (related to your stay dates for arrival, activities, and departure)
                </div>
            </div>

            <!-- Ferry Schedules -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Available Ferry Schedules</h3>
                        <a href="{{ route('ferry.request') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Request Tickets
                        </a>
                    </div>

                    @if($schedules->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($schedules as $schedule)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $schedule->departure_time->format('M d, Y') }}
                                        </h4>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $schedule->departure_time->format('g:i A') }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Route:</strong> {{ $schedule->origin }} → {{ $schedule->destination }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Available Seats:</strong> 
                                            <span class="font-semibold {{ $schedule->is_available ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                {{ $schedule->remaining_capacity }}/{{ $schedule->seats_available }}
                                            </span>
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                            $25.00
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            per ticket
                                        </span>
                                    </div>
                                    
                                    @if($schedule->is_available)
                                        <div class="mt-3">
                                            <a href="{{ route('ferry.request') }}?schedule={{ $schedule->id }}" class="w-full inline-flex justify-center items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Request Tickets
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-3">
                                            <span class="w-full inline-flex justify-center items-center px-3 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-not-allowed">
                                                Fully Booked
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Ferry Schedules Available</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">
                                No ferry schedules are available for your stay dates ({{ $booking->check_in_date->copy()->subDay()->format('M d') }} - {{ $booking->check_out_date->copy()->addDay()->format('M d, Y') }}).
                            </p>
                            <p class="text-sm text-gray-400 dark:text-gray-500">
                                Ferry schedules may be added closer to your check-in date, or you can contact our staff for assistance.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="mt-6 text-center">
                <a href="{{ route('visitor-dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
