<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Hotel Staff Dashboard">
        <div class="space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage hotel operations, bookings, and room availability.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Rooms -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-dynamic-component component="fluentui-conference-room-20-o" class="w-8 h-8 text-blue-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rooms</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_rooms'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-dynamic-component component="radix-calendar" class="w-8 h-8 text-green-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Bookings</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total_bookings'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-dynamic-component component="radix-dashboard" class="w-8 h-8 text-purple-600" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Quick Actions</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">Manage operations</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Recent Bookings</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guest</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-in</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($stats['recent_bookings'] as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $booking->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $booking->room->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $booking->check_in_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $booking->check_out_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->check_out_date->isPast())
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                                Completed
                                            </span>
                                        @elseif($booking->check_in_date->isPast())
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-200">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-200">
                                                Upcoming
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No recent bookings found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('hotelstaff.rooms.index') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <x-dynamic-component component="fluentui-conference-room-20-o" class="w-6 h-6 text-blue-600 mr-3" />
                        <span class="text-gray-900 dark:text-gray-100">Manage Rooms</span>
                    </a>
                    <a href="{{ route('hotelstaff.bookings.index') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <x-dynamic-component component="radix-calendar" class="w-6 h-6 text-green-600 mr-3" />
                        <span class="text-gray-900 dark:text-gray-100">Manage Bookings</span>
                    </a>
                    <a href="{{ route('hotelstaff.reports.index') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <x-dynamic-component component="radix-bar-chart" class="w-6 h-6 text-purple-600 mr-3" />
                        <span class="text-gray-900 dark:text-gray-100">View Reports</span>
                    </a>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout> 