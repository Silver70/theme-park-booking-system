<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Ticket Details">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Ferry Ticket Details</h1>
                        <p class="text-gray-600 dark:text-gray-400">View ferry ticket information (read-only mode).</p>
                    </div>
                    <a href="{{ route('admin.ferry.tickets') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to Tickets
                    </a>
                </div>
            </div>

            <!-- Ticket Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ticket Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket ID</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">#{{ $ticket->id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">${{ number_format($ticket->price, 2) }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                @if($ticket->is_used)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        Used
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                        Unused
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        
                        @if($ticket->is_used)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Used At</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Passenger Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Passenger Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Passenger Name</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->email ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <x-role-badge :user="$ticket->user" />
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @if($ticket->user)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $ticket->user->created_at ? $ticket->user->created_at->format('M d, Y') : 'Not set' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Ferry Tickets</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->ferryTickets()->count() }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Bookings</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->bookings()->count() }}</p>
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Status</label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">User not found or deleted</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Schedule Information</h2>
                
                @if($ticket->ferrySchedule)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Schedule ID</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">#{{ $ticket->ferrySchedule->id }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vessel</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ $ticket->ferrySchedule->vessel->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departure Time</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $ticket->ferrySchedule->departure_time ? $ticket->ferrySchedule->departure_time->format('M d, Y \a\t g:i A') : 'Not set' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival Time</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $ticket->ferrySchedule->arrival_time ? $ticket->ferrySchedule->arrival_time->format('M d, Y \a\t g:i A') : 'Not set' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Schedule Status</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    @if($ticket->ferrySchedule->cancelled_at)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                            Cancelled
                                        </span>
                                    @elseif($ticket->ferrySchedule->departure_time && $ticket->ferrySchedule->departure_time->isPast())
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400">
                                            Completed
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                            Scheduled
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No schedule information found for this ticket.</p>
                @endif
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
