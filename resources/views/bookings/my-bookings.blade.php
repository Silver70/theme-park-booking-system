<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold mb-2">My Bookings</h1>
                        <p class="text-gray-600 dark:text-gray-400">View all your hotel bookings and their current status</p>
                    </div>

                    @if($bookings->count() > 0)
                        <div class="space-y-6">
                            @foreach($bookings as $booking)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $booking->room->name }}
                                                </h3>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $booking->booking_status_color }}">
                                                    {{ $booking->booking_status_text }}
                                                </span>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                    @if($booking->check_out_date >= now())
                                                        bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                    @else
                                                        bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                                                    @endif">
                                                    @if($booking->check_out_date >= now())
                                                        Active
                                                    @else
                                                        Completed
                                                    @endif
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y') }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y') }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <strong>Duration:</strong> {{ $booking->check_in_date->diffInDays($booking->check_out_date) }} days
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <strong>Booking Reference:</strong> #{{ $booking->id }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        <strong>Stay Status:</strong> {{ ucfirst($booking->status) }}
                                                    </p>
                                                    @if($booking->booking_status === 'confirmed' && $booking->confirmed_at)
                                                        <p class="text-gray-600 dark:text-gray-400">
                                                            <strong>Confirmed:</strong> {{ $booking->confirmed_at->format('M d, Y \a\t g:i A') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            @php
                                                $ferryStatus = $booking->ferry_request_status;
                                            @endphp
                                            
                                            @if($ferryStatus == 'has_tickets')
                                                <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-700">
                                                    <h4 class="font-medium text-green-800 dark:text-green-200 mb-2">✅ Ferry Tickets Issued</h4>
                                                    @foreach($booking->ferryTickets as $ticket)
                                                        <div class="text-sm text-green-700 dark:text-green-300">
                                                            @if($ticket->ferrySchedule)
                                                                <strong>Schedule:</strong> {{ $ticket->ferrySchedule->departure_time->format('M d, g:i A') }} 
                                                                ({{ $ticket->ferrySchedule->origin }} → {{ $ticket->ferrySchedule->destination }})
                                                            @else
                                                                <strong>Status:</strong> Schedule not assigned yet
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif($ferryStatus == 'pending_request')
                                                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded border border-yellow-200 dark:border-yellow-700">
                                                    <h4 class="font-medium text-yellow-800 dark:text-yellow-200 mb-1">⏳ Ferry Request Pending</h4>
                                                    <p class="text-sm text-yellow-700 dark:text-yellow-300">Your ferry ticket request is being reviewed by our operators.</p>
                                                </div>
                                            @elseif($ferryStatus == 'approved_request')
                                                <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-700">
                                                    <h4 class="font-medium text-green-800 dark:text-green-200 mb-1">✅ Ferry Request Approved</h4>
                                                    <p class="text-sm text-green-700 dark:text-green-300">Your request has been approved! Ferry tickets will be issued shortly.</p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="ml-4 flex flex-col space-y-2">
                                            <a href="{{ route('bookings.confirmation', $booking->id) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                View Details
                                            </a>
                                            @if($booking->check_out_date >= now())
                                                @php
                                                    $ferryStatus = $booking->ferry_request_status;
                                                @endphp
                                                
                                                @if($ferryStatus == 'has_tickets')
                                                    <a href="{{ route('ferry.my-requests') }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        View Ferry Tickets
                                                    </a>
                                                @elseif($ferryStatus == 'pending_request')
                                                    <a href="{{ route('ferry.my-requests') }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        View Pending Request
                                                    </a>
                                                @elseif($ferryStatus == 'approved_request')
                                                    <a href="{{ route('ferry.my-requests') }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        View Approved Request
                                                    </a>
                                                @else
                                                    <a href="{{ route('ferry.request') }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Request Ferry Tickets
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($bookings->hasPages())
                            <div class="mt-6">
                                {{ $bookings->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Bookings Found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't made any hotel bookings yet.</p>
                            <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Book Your First Room
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
