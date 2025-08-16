<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Header -->
            <div class="mb-8 text-center">
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Booking Confirmed!</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">Your room has been successfully reserved</p>
            </div>

            <!-- Booking Details Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-blue-200 dark:border-blue-700">
                    <h2 class="text-xl font-semibold text-blue-800 dark:text-blue-200">Booking Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Booking Reference -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">Booking Reference</h3>
                            <div class="text-center">
                                <div class="text-3xl font-mono font-bold text-blue-600 dark:text-blue-400 mb-2">
                                    {{ $booking->booking_reference }}
                                </div>
                                <p class="text-sm text-blue-600 dark:text-blue-400">Please save this reference number</p>
                            </div>
                        </div>

                        <!-- Booking Status -->
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-700">
                            <h3 class="font-semibold text-green-800 dark:text-green-200 mb-2">Status</h3>
                            <div class="text-center">
                                <div class="text-2xl font-bold {{ $booking->status_color }} mb-2">
                                    {{ $booking->status_text }}
                                </div>
                                <p class="text-sm text-green-600 dark:text-green-400">Your booking is confirmed</p>
                            </div>
                        </div>
                    </div>

                    <!-- Room Details -->
                    <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Room Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Room Name:</strong> {{ $booking->room->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Description:</strong> {{ $booking->room->description }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Capacity:</strong> {{ $booking->room->capacity ?? 'N/A' }} guests
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Room ID:</strong> #{{ $booking->room->id }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stay Details -->
                    <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Stay Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Check-in Date:</strong> {{ $booking->check_in_date->format('l, F d, Y') }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Check-in Time:</strong> {{ $booking->check_in_date->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Check-out Date:</strong> {{ $booking->check_out_date->format('l, F d, Y') }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Check-out Time:</strong> {{ $booking->check_out_date->format('g:i A') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Duration:</strong> {{ $booking->check_in_date->diffInDays($booking->check_out_date) }} nights
                            </p>
                        </div>
                    </div>

                    <!-- Guest Information -->
                    <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Guest Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Guest Name:</strong> {{ $booking->user->name }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Email:</strong> {{ $booking->user->email }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y \a\t g:i A') }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Booking ID:</strong> #{{ $booking->id }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-700 p-6 mb-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200 mb-2">Important Information</h3>
                        <div class="text-sm text-yellow-700 dark:text-yellow-300 space-y-2">
                            <p>• <strong>Save your booking reference:</strong> {{ $booking->booking_reference }} - You'll need this for check-in</p>
                            <p>• <strong>Check-in time:</strong> 3:00 PM on your arrival date</p>
                            <p>• <strong>Check-out time:</strong> 11:00 AM on your departure date</p>
                            <p>• <strong>Early check-in/late check-out:</strong> Subject to availability, please contact reception</p>
                            <p>• <strong>Cancellation policy:</strong> Free cancellation up to 24 hours before check-in</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('visitor-dashboard') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Go to Dashboard
                </a>
                
                                       <a href="{{ route('visitor.ferry.schedules') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                           <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                           </svg>
                           Book Ferry Tickets
                       </a>

                <button onclick="window.print()" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4a2 2 0 002 2h6a2 2 0 002 2z"></path>
                    </svg>
                    Print Confirmation
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
