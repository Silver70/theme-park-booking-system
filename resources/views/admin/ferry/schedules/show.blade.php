<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Schedule Details">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Ferry Schedule Details</h1>
                        <p class="text-gray-600 dark:text-gray-400">View ferry schedule information (read-only mode).</p>
                    </div>
                    <a href="{{ route('admin.ferry.schedules') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to Schedules
                    </a>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Schedule Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Schedule ID</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">#{{ $schedule->id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vessel</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $schedule->vessel->name ?? 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departure Time</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $schedule->departure_time ? $schedule->departure_time->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Arrival Time</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $schedule->arrival_time ? $schedule->arrival_time->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                @if($schedule->cancelled_at)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                        Cancelled
                                    </span>
                                @elseif($schedule->departure_time && $schedule->departure_time->isPast())
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
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $schedule->created_at ? $schedule->created_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $schedule->updated_at ? $schedule->updated_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                        
                        @if($schedule->cancelled_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cancelled At</label>
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $schedule->cancelled_at ? $schedule->cancelled_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Schedule Statistics -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Schedule Statistics</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $schedule->ferryTickets()->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Tickets</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $schedule->ferryTickets()->where('is_used', false)->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Unused Tickets</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ $schedule->ferryTickets()->where('is_used', true)->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Used Tickets</div>
                    </div>
                </div>
            </div>

            <!-- Ticket Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ticket Information</h2>
                
                @if($schedule->ferryTickets()->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Passenger</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ticket ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($schedule->ferryTickets()->with('user')->get() as $ticket)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $ticket->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            #{{ $ticket->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            @if($ticket->is_used)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                    Used
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                                    Unused
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            ${{ number_format($ticket->price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No tickets found for this schedule.</p>
                @endif
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
