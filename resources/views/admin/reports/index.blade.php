<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Admin Dashboard">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Reports & Analytics</h1>
                        <p class="text-gray-600 dark:text-gray-400">View comprehensive reports and analytics for your resort.</p>
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

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">Export Reports</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">Download CSV/PDF</p>
                        </div>
                    </button>

                    <button class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700 hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-900 dark:text-green-100">Generate Charts</p>
                            <p class="text-xs text-green-600 dark:text-green-400">Visual analytics</p>
                        </div>
                    </button>

                    <button class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-purple-900 dark:text-purple-100">Email Reports</p>
                            <p class="text-xs text-purple-600 dark:text-purple-400">Send to stakeholders</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout> 