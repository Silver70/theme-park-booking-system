<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Tickets">
        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <div class="p-6">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Ferry Passenger List</h1>
                    <p class="text-gray-600 mt-2">View all issued ferry tickets and passenger information</p>
                </div>

                <!-- Passenger Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Total Tickets</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $tickets->total() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Passengers</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $tickets->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">With Schedules</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $tickets->whereNotNull('ferry_schedule_id')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Total Revenue</p>
                                <p class="text-2xl font-semibold text-gray-900">${{ number_format($tickets->sum('price'), 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passenger List Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v1a2 2 0 002 2h2m0-4h2m0 0h2a2 2 0 012 2v1a2 2 0 01-2 2h-2m-4 0V9a2 2 0 012-2h2a2 2 0 012 2v1"></path>
                            </svg>
                            Ferry Passenger List
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">All passengers with issued ferry tickets</p>
                    </div>

                    @if($tickets->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ticket ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Passenger Details
                                        </th>
                                    
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ferry Schedule
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Issued Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tickets as $ticket)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Ticket ID -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8">
                                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                            <span class="text-xs font-medium text-blue-600">#{{ $ticket->id }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Passenger Details -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $ticket->user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $ticket->user->email }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Booking Info -->
                                          

                                            <!-- Ferry Schedule -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($ticket->ferrySchedule)
                                                    <div class="text-sm text-gray-900">
                                                        <div class="font-medium">
                                                            {{ \Carbon\Carbon::parse($ticket->ferrySchedule->departure_time)->format('M d, g:i A') }}
                                                        </div>
                                                        <div class="text-gray-500 flex items-center">
                                                            <span>{{ $ticket->ferrySchedule->origin }}</span>
                                                            <svg class="w-3 h-3 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                            </svg>
                                                            <span>{{ $ticket->ferrySchedule->destination }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Unassigned
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Price -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">${{ number_format($ticket->price, 2) }}</div>
                                            </td>

                                            <!-- Status -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($ticket->ferrySchedule && $ticket->ferrySchedule->departure_time->isPast())
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Completed
                                                    </span>
                                                @elseif($ticket->ferrySchedule)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Scheduled
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Active
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Issued Date -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div>{{ $ticket->created_at->format('M d, Y') }}</div>
                                                <div class="text-xs text-gray-400">{{ $ticket->created_at->format('g:i A') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($tickets->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $tickets->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No ferry tickets issued</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by issuing your first ferry ticket.</p>
                            <div class="mt-6">
                                <a href="{{ route('ferry.tickets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Ferry Ticket
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout>