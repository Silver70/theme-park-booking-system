<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Booking Details">
        <div class="space-y-6">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Booking Details</h1>
                        <p class="text-gray-600 dark:text-gray-400">View booking information (read-only mode).</p>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to Bookings
                    </a>
                </div>
            </div>

            <!-- Booking Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Booking Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking ID</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">#{{ $booking->id }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
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
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $booking->created_at ? $booking->created_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $booking->updated_at ? $booking->updated_at->format('M d, Y \a\t g:i A') : 'Not set' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Dates -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-in Date</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $booking->check_in_date ? $booking->check_in_date->format('M d, Y') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Check-out Date</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $booking->check_out_date ? $booking->check_out_date->format('M d, Y') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-300">Duration</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ ($booking->check_in_date && $booking->check_out_date) ? $booking->check_in_date->diffInDays($booking->check_out_date) . ' days' : 'Not set' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guest Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Guest Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Guest Name</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->user->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                            <x-role-badge :user="$booking->user" />
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Member Since</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $booking->user->created_at ? $booking->user->created_at->format('M d, Y') : 'Not set' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Bookings</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->user->bookings()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Room Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Name</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->room->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->room->description }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price per Night</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $booking->room->formatted_price }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Cost</label>
                            <p class="text-sm text-gray-900 dark:text-gray-100">${{ number_format($booking->room->price * $booking->check_in_date->diffInDays($booking->check_out_date), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout>
