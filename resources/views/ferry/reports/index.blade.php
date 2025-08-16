<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Operator Dashboard">
        <div class="space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Ferry Operations Reports
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Comprehensive analytics and insights for your ferry operations
                </p>
            </div>

            <!-- Key Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Schedules -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Schedules</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($reports['schedule_stats']['total_schedules']) }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                {{ $reports['schedule_stats']['active_schedules'] }} active
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Total Tickets -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tickets</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($reports['ticket_stats']['total_tickets']) }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                {{ $reports['ticket_stats']['tickets_this_month'] }} this month
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">${{ number_format($reports['revenue_stats']['total_revenue'], 2) }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                ${{ number_format($reports['revenue_stats']['this_month_revenue'], 2) }} this month
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Capacity Utilization -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Utilization Rate</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $reports['capacity_stats']['utilization_rate'] }}%</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                {{ number_format($reports['capacity_stats']['total_booked']) }}/{{ number_format($reports['capacity_stats']['total_capacity']) }} seats
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Schedule Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Schedule Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active Schedules:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['schedule_stats']['active_schedules'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Completed Schedules:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['schedule_stats']['completed_schedules'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Cancelled Schedules:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['schedule_stats']['cancelled_schedules'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">This Week:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['schedule_stats']['this_week'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">This Month:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['schedule_stats']['this_month'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ticket Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ticket Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tickets Today:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['ticket_stats']['tickets_today'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">This Week:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['ticket_stats']['tickets_this_week'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">This Month:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['ticket_stats']['tickets_this_month'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Used Tickets:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['ticket_stats']['used_tickets'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Unused Tickets:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['ticket_stats']['unused_tickets'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Routes -->
            @if($popularRoutes->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Popular Routes</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Route</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Trips</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Seats</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($popularRoutes as $route)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $route->route }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $route->trips }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ number_format($route->total_seats) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Recent Schedules Performance -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Schedule Performance</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Departure</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Route</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capacity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Utilization</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($recentSchedules->take(10) as $schedule)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $schedule->departure_time->format('M d, Y g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $schedule->origin }} → {{ $schedule->destination }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $schedule->ticket_count }}/{{ $schedule->seats_available }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $schedule->capacity_used }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-500 dark:text-gray-300">{{ $schedule->capacity_used }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($schedule->cancelled_at)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        @elseif($schedule->departure_time > now())
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Scheduled
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Completed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Revenue Insights -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Revenue Insights</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-600">${{ number_format($reports['revenue_stats']['this_week_revenue'], 2) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Week</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">${{ number_format($reports['revenue_stats']['this_month_revenue'], 2) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">This Month</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-purple-600">${{ number_format($reports['revenue_stats']['average_ticket_price'], 2) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Average Ticket Price</p>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
