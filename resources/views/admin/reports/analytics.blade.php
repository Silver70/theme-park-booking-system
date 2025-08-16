<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Admin Dashboard">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Analytics & Data Export</h1>
                        <p class="text-gray-600 dark:text-gray-400">Visual analytics, data visualization, and export functionality for your resort.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Back to Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Data Export Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Export Data</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Download comprehensive reports in CSV format for further analysis.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <form method="POST" action="{{ route('admin.reports.export') }}" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="bookings">
                        <input type="hidden" name="format" value="csv">
                        <button type="submit" class="w-full p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700 hover:bg-blue-100 dark:hover:bg-blue-800/30 transition-colors">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="text-center">
                                <div class="text-sm font-medium text-blue-900 dark:text-blue-100">Export Bookings</div>
                                <div class="text-xs text-blue-600 dark:text-blue-400">CSV format</div>
                            </div>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.reports.export') }}" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="users">
                        <input type="hidden" name="format" value="csv">
                        <button type="submit" class="w-full p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700 hover:bg-green-100 dark:hover:bg-green-800/30 transition-colors">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="text-center">
                                <div class="text-sm font-medium text-green-900 dark:text-green-100">Export Users</div>
                                <div class="text-xs text-green-600 dark:text-green-400">CSV format</div>
                            </div>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.reports.export') }}" class="inline">
                        @csrf
                        <input type="hidden" name="type" value="revenue">
                        <input type="hidden" name="format" value="csv">
                        <button type="submit" class="w-full p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700 hover:bg-purple-100 dark:hover:bg-purple-800/30 transition-colors">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="text-center">
                                <div class="text-sm font-medium text-purple-900 dark:text-purple-100">Export Revenue</div>
                                <div class="text-xs text-purple-600 dark:text-purple-400">CSV format</div>
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Monthly Revenue Chart -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Monthly Revenue Trend</h3>
                    @if(isset($chartData['monthly_revenue']) && count($chartData['monthly_revenue']) > 0)
                        <div class="h-64 flex items-end justify-between space-x-2">
                            @foreach($chartData['monthly_revenue'] as $month)
                                <div class="flex flex-col items-center">
                                    @php
                                        $maxRevenue = max(array_column($chartData['monthly_revenue'], 'revenue'));
                                        $height = $maxRevenue > 0 ? max(10, ($month['revenue'] / $maxRevenue) * 200) : 10;
                                    @endphp
                                    <div class="w-8 bg-blue-500 rounded-t" style="height: {{ $height }}px;"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-center">
                                        {{ $month['month'] ?? 'Unknown' }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-900 dark:text-gray-100">
                                        ${{ number_format($month['revenue'] ?? 0, 0) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex justify-between">
                                <span>Total Revenue: ${{ number_format(array_sum(array_column($chartData['monthly_revenue'], 'revenue')), 2) }}</span>
                                <span>Average: ${{ number_format(array_sum(array_column($chartData['monthly_revenue'], 'revenue')) / count($chartData['monthly_revenue']), 2) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="h-64 flex items-center justify-center">
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No revenue data available</p>
                        </div>
                    @endif
                </div>

                <!-- User Growth Chart -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">User Growth</h3>
                    @if(isset($chartData['user_growth']) && count($chartData['user_growth']) > 0)
                        <div class="h-64 flex items-end justify-between space-x-2">
                            @foreach($chartData['user_growth'] as $month)
                                <div class="flex flex-col items-center">
                                    @php
                                        $maxUsers = max(array_column($chartData['user_growth'], 'users'));
                                        $height = $maxUsers > 0 ? max(10, ($month['users'] / $maxUsers) * 200) : 10;
                                    @endphp
                                    <div class="w-8 bg-green-500 rounded-t" style="height: {{ $height }}px;"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-center">
                                        {{ $month['month'] ?? 'Unknown' }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-900 dark:text-gray-100">
                                        {{ $month['users'] ?? 0 }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex justify-between">
                                <span>Total New Users: {{ array_sum(array_column($chartData['user_growth'], 'users')) }}</span>
                                <span>Average: {{ round(array_sum(array_column($chartData['user_growth'], 'users')) / count($chartData['user_growth']), 1) }}</span>
                            </div>
                        </div>
                    @else
                        <div class="h-64 flex items-center justify-center">
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No user growth data available</p>
                        </div>
                    @endif
                </div>

                <!-- Top Performing Rooms -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top Performing Rooms</h3>
                    <div class="space-y-3">
                        @if(isset($chartData['top_rooms']) && count($chartData['top_rooms']) > 0)
                            @foreach($chartData['top_rooms'] as $room)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $room['name'] ?? 'Unknown Room' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $room['bookings'] ?? 0 }} bookings</div>
                                    </div>
                                    <div class="text-sm font-medium text-green-600 dark:text-green-400">
                                        ${{ number_format($room['revenue'] ?? 0, 2) }}
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    @php
                                        $maxBookings = max(array_column($chartData['top_rooms'], 'bookings'));
                                        $percentage = $maxBookings > 0 ? (($room['bookings'] ?? 0) / $maxBookings) * 100 : 0;
                                    @endphp
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No room data available</p>
                        @endif
                    </div>
                </div>

                <!-- Ferry Usage Statistics -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ferry Route Performance</h3>
                    <div class="space-y-3">
                        @if(isset($chartData['ferry_usage']) && count($chartData['ferry_usage']) > 0)
                            @foreach(array_slice($chartData['ferry_usage'], 0, 5) as $route)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($route['route'] ?? 'Unknown Route', 25) }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $route['tickets'] ?? 0 }} tickets sold</div>
                                    </div>
                                    <div class="text-sm font-medium text-green-600 dark:text-green-400">
                                        ${{ number_format($route['revenue'] ?? 0, 2) }}
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    @php
                                        $maxTickets = max(array_column($chartData['ferry_usage'], 'tickets'));
                                        $percentage = $maxTickets > 0 ? (($route['tickets'] ?? 0) / $maxTickets) * 100 : 0;
                                    @endphp
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No ferry usage data available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Data Summary -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Data Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ isset($chartData['monthly_revenue']) ? count($chartData['monthly_revenue']) : 0 }}
                        </div>
                        <div class="text-sm text-blue-800 dark:text-blue-200">Months Tracked</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ isset($chartData['monthly_revenue']) ? array_sum(array_column($chartData['monthly_revenue'], 'bookings')) : 0 }}
                        </div>
                        <div class="text-sm text-green-800 dark:text-green-200">Total Bookings</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            {{ isset($chartData['user_growth']) ? array_sum(array_column($chartData['user_growth'], 'users')) : 0 }}
                        </div>
                        <div class="text-sm text-purple-800 dark:text-purple-200">New Users</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ isset($chartData['room_occupancy']) ? count($chartData['room_occupancy']) : 0 }}
                        </div>
                        <div class="text-sm text-yellow-800 dark:text-yellow-200">Rooms Analyzed</div>
                    </div>
                </div>
            </div>


        </div>
    </x-sidebar>
</x-app-layout>
