<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Admin Dashboard">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Reports & Analytics</h1>
                        <p class="text-gray-600 dark:text-gray-400">Generate usage and sales reports, plus system analytics for your resort.</p>
                        <div class="mt-2">
                            <a href="{{ route('admin.reports.analytics') }}" class="inline-flex items-center px-3 py-1 bg-indigo-100 dark:bg-indigo-900/20 text-indigo-800 dark:text-indigo-200 text-xs font-medium rounded-md hover:bg-indigo-200 dark:hover:bg-indigo-900/30 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                View Analytics
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Booking Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Bookings</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $reports['booking_stats']['total'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Bookings -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">This Month</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $reports['booking_stats']['this_month'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $reports['user_stats']['total'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">${{ number_format($reports['revenue_stats']['total_room_revenue'] + $reports['revenue_stats']['total_ferry_revenue'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Reports -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- User Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">User Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Visitors</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['user_stats']['visitors'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Hotel Owners</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['user_stats']['hotel_owners'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Ferry Operators</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['user_stats']['ferry_operators'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Admins</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['user_stats']['admins'] }}</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Verified Users</span>
                                <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $reports['user_stats']['verified_users'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">New This Month</span>
                                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $reports['user_stats']['new_this_month'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Breakdown -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Revenue Breakdown</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Room Revenue</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">${{ number_format($reports['revenue_stats']['total_room_revenue'], 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Ferry Revenue</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">${{ number_format($reports['revenue_stats']['total_ferry_revenue'], 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Total Revenue</span>
                                <span class="text-sm font-bold text-green-600 dark:text-green-400">${{ number_format($reports['revenue_stats']['total_room_revenue'] + $reports['revenue_stats']['total_ferry_revenue'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Detailed Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Booking Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Booking Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">This Month</span>
                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $reports['booking_stats']['this_month'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Last Month</span>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $reports['booking_stats']['last_month'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Pending</span>
                            <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">{{ $reports['booking_stats']['pending'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $reports['booking_stats']['active'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $reports['booking_stats']['completed'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Room Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Room Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Rooms</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['room_stats']['total_rooms'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Available</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $reports['room_stats']['available_rooms'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Occupied</span>
                            <span class="text-sm font-medium text-red-600 dark:text-red-400">{{ $reports['room_stats']['occupied_rooms'] }}</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                @foreach($reports['room_stats']['room_types'] as $type)
                                    <div class="flex justify-between items-center">
                                        <span>{{ $type->capacity }} Person Room</span>
                                        <span class="font-medium">{{ $type->count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ferry Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ferry Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Schedules</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reports['ferry_stats']['total_schedules'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active Schedules</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $reports['ferry_stats']['active_schedules'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Tickets</span>
                            <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $reports['ferry_stats']['total_tickets'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Used Tickets</span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">{{ $reports['ferry_stats']['used_tickets'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Unused Tickets</span>
                            <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">{{ $reports['ferry_stats']['unused_tickets'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage & Sales Reports -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Usage & Sales Reports</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 bg-blue-500 rounded-md flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100">Room Usage Report</h4>
                        </div>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mb-2">Track room occupancy and utilization rates</p>
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            <div class="flex justify-between">
                                <span>Total Bookings:</span>
                                <span class="font-medium">{{ $reports['revenue_stats']['total_bookings'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 bg-green-500 rounded-md flex items-center justify-center mr-2">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-medium text-green-900 dark:text-green-100">Sales Performance</h4>
                        </div>
                        <p class="text-xs text-green-600 dark:text-green-400 mb-2">Monitor revenue trends and sales metrics</p>
                        <div class="text-sm text-green-800 dark:text-green-200">
                            <div class="flex justify-between">
                                <span>Total Revenue:</span>
                                <span class="font-medium">${{ number_format($reports['revenue_stats']['total_room_revenue'] + $reports['revenue_stats']['total_ferry_revenue'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Analytics & Data Export</h3>
                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-700">
                    <div class="flex items-center mb-3">
                        <div class="w-6 h-6 bg-yellow-500 rounded-md flex items-center justify-center mr-2">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-yellow-900 dark:text-yellow-100">View Analytics</h4>
                    </div>
                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mb-2">Access detailed charts, analytics, and export functionality</p>
                    <a href="{{ route('admin.reports.analytics') }}" class="mt-2 text-xs bg-yellow-100 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-200 px-3 py-1 rounded-md hover:bg-yellow-200 dark:hover:bg-yellow-700 transition-colors inline-block text-center">
                        View Analytics
                    </a>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout> 