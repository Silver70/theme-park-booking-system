<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Ferry Ticket Requests') }}
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
            </div>

            <!-- Ferry Ticket Requests -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Ferry Ticket Requests</h3>
                        <a href="{{ route('ferry.request') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Request
                        </a>
                    </div>

                    @if($requests->count() > 0)
                        <div class="space-y-4">
                            @foreach($requests as $request)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $request->status_badge_color }}">
                                                    {{ $request->status_text }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                                    Request #{{ $request->id }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm">Schedule Details</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $request->ferrySchedule->departure_time->format('M d, Y \a\t g:i A') }}
                                                    </p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $request->ferrySchedule->origin }} → {{ $request->ferrySchedule->destination }}
                                                    </p>
                                                </div>
                                                
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm">Ticket Details</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        Quantity: {{ $request->quantity }} ticket(s)
                                                    </p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        Total: ${{ number_format($request->total_price, 2) }}
                                                    </p>
                                                </div>
                                                
                                                <div>
                                                    <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm">Request Details</h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        Submitted: {{ $request->created_at->format('M d, Y g:i A') }}
                                                    </p>
                                                    @if($request->notes)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                                            Notes: {{ Str::limit($request->notes, 50) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($request->isApproved())
                                                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-3">
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        <div>
                                                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                                                Request Approved
                                                            </p>
                                                            <p class="text-xs text-green-600 dark:text-green-400">
                                                                Approved by {{ $request->approver->name ?? 'Staff' }} on {{ $request->approved_at->format('M d, Y g:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($request->isDenied())
                                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-3">
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        <div>
                                                            <p class="text-sm font-medium text-red-800 dark:text-red-200">
                                                                Request Denied
                                                            </p>
                                                            @if($request->denial_reason)
                                                                <p class="text-xs text-red-600 dark:text-red-400">
                                                                    Reason: {{ $request->denial_reason }}
                                                                </p>
                                                            @endif
                                                            <p class="text-xs text-red-600 dark:text-red-400">
                                                                Denied on {{ $request->denied_at->format('M d, Y g:i A') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($request->isPending())
                                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3">
                                                    <div class="flex items-center">
                                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <div>
                                                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                                                Request Pending Review
                                                            </p>
                                                            <p class="text-xs text-yellow-600 dark:text-yellow-400">
                                                                Your request is being reviewed by ferry operators. You'll be notified once a decision is made.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Ferry Requests Yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't submitted any ferry ticket requests yet.</p>
                            <a href="{{ route('ferry.request') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Submit Your First Request
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('visitor-dashboard') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
