<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Room Details">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Room Details</h1>
                        <p class="text-gray-600 dark:text-gray-400">View room information (read-only mode).</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← Back to Rooms
                        </a>
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Room Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Name</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $room->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $room->description }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price per Night</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $room->formatted_price }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacity</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $room->capacity }} guests</p>
                        </div>
                    </div>
                    
                    <!-- Additional Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                @if($room->is_available)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        Available
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                        Occupied
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $room->created_at ? $room->created_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $room->updated_at ? $room->updated_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Statistics -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Room Statistics</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $room->bookings()->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Bookings</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $room->bookings()->where('check_out_date', '>=', now())->count() }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Active Bookings</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                            ${{ number_format($room->bookings()->sum(\DB::raw('DATEDIFF(check_out_date, check_in_date) * ' . $room->price)), 2) }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Revenue</div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Bookings</h2>
                
                @if($room->bookings()->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guest</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-in</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-out</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($room->bookings()->latest()->take(5)->get() as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $booking->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $booking->check_in_date ? $booking->check_in_date->format('M d, Y') : 'Not set' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $booking->check_out_date ? $booking->check_out_date->format('M d, Y') : 'Not set' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            @if($booking->check_out_date && $booking->check_out_date->isPast())
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400">
                                                    Completed
                                                </span>
                                            @elseif($booking->check_in_date && $booking->check_in_date->isPast())
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                                    Upcoming
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No bookings found for this room.</p>
                @endif
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
