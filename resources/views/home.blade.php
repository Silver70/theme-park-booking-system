<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Welcome to Our Resort') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-800/30 border border-green-200 dark:border-green-700 rounded-lg">
                            <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-800/30 border border-red-200 dark:border-red-700 rounded-lg">
                            <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold mb-4">Welcome {{ Auth::user()->name }}!</h1>
                    
                    <!-- Top Dashboard Images -->
                    @if(isset($dashboardImages['top']) && $dashboardImages['top']->count() > 0)
                        <div class="mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($dashboardImages['top'] as $image)
                                    <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm">
                                        <img src="{{ Storage::url($image->image_path) }}" 
                                             alt="{{ $image->title }}" 
                                             class="w-full h-48 object-cover">
                                        @if($image->title || $image->description)
                                            <div class="p-4">
                                                @if($image->title)
                                                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $image->title }}</h3>
                                                @endif
                                                @if($image->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $image->description }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Resort Map Section -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg border border-indigo-200 dark:border-indigo-700">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-xl font-semibold text-indigo-800 dark:text-indigo-200">Explore Our Resort</h2>
                                <p class="text-indigo-600 dark:text-indigo-400 text-sm">Discover restaurants, activities, and points of interest</p>
                            </div>
                            <a href="{{ route('map.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                View Map
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                                <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Resort Locations</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Find your way around</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Restaurants</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Dining options</p>
                            </div>
                            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">Activities</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Things to do</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($booking)
                        <!-- Booking Information -->
                        <div class="mb-8 p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold text-blue-800 dark:text-blue-200">Your Current Booking</h2>
                                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $booking->booking_status_color }}">
                                    {{ $booking->booking_status_text }}
                                </span>
                            </div>
                            @if($booking->booking_status === 'pending')
                                <div class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded border border-yellow-200 dark:border-yellow-700">
                                    <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                                        <strong>Note:</strong> Your booking is pending confirmation from hotel staff.
                                    </p>
                                </div>
                            @elseif($booking->booking_status === 'confirmed' && $booking->confirmed_at)
                                <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 rounded border border-green-200 dark:border-green-700">
                                    <p class="text-green-800 dark:text-green-200 text-sm">
                                        <strong>Confirmed:</strong> Your booking was confirmed on {{ $booking->confirmed_at->format('M d, Y') }}
                                    </p>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h3 class="font-semibold text-blue-700 dark:text-blue-300">Room Details</h3>
                                    <p class="text-blue-600 dark:text-blue-400">{{ $booking->room->name }}</p>
                                    <p class="text-blue-600 dark:text-blue-400">{{ $booking->room->description }}</p>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-blue-700 dark:text-blue-300">Stay Details</h3>
                                    <p class="text-blue-600 dark:text-blue-400">
                                        <strong>Check-in:</strong> {{ $booking->check_in_date->format('M d, Y') }}
                                    </p>
                                    <p class="text-blue-600 dark:text-blue-400">
                                        <strong>Check-out:</strong> {{ $booking->check_out_date->format('M d, Y') }}
                                    </p>
                                    <p class="text-blue-600 dark:text-blue-400">
                                        <strong>Booking Reference:</strong> 
                                        <span class="font-mono font-bold text-lg">{{ $booking->booking_reference }}</span>
                                    </p>
                                    <p class="text-blue-600 dark:text-blue-400">
                                        <strong>Status:</strong> 
                                        <span class="font-semibold {{ $booking->status_color }}">{{ $booking->status_text }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Ferry Pass Information -->
                        @if($hasFerryPass)
                            <div class="mb-8 p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                                <h2 class="text-xl font-semibold text-green-800 dark:text-green-200 mb-4">Ferry Pass Status</h2>
                                
                                @if($ferryPassAssigned)
                                    <div class="bg-green-100 dark:bg-green-800/30 p-4 rounded-lg">
                                        <h3 class="font-semibold text-green-800 dark:text-green-200 mb-2">✅ Ferry Pass Confirmed</h3>
                                        <p class="text-green-700 dark:text-green-300 mb-3">
                                            Your ferry pass has been assigned to a specific schedule.
                                        </p>
                                        @if($ferryTicket->ferrySchedule)
                                            <div class="bg-white dark:bg-gray-700 p-3 rounded border">
                                                <h4 class="font-semibold text-gray-800 dark:text-gray-200">Schedule Details:</h4>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    <strong>Departure:</strong> {{ $ferryTicket->ferrySchedule->departure_time->format('M d, Y \a\t g:i A') }}
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    <strong>Route:</strong> {{ $ferryTicket->ferrySchedule->origin }} → {{ $ferryTicket->ferrySchedule->destination }}
                                                </p>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    <strong>Ticket ID:</strong> #{{ $ferryTicket->id }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-yellow-100 dark:bg-yellow-800/30 p-4 rounded-lg">
                                        <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">🎫 Free Ferry Pass Available</h3>
                                        <p class="text-yellow-700 dark:text-yellow-300 mb-4">
                                            You have a free ferry pass included with your booking! Please select your preferred ferry schedule below.
                                        </p>
                                        
                                        @if($availableSchedules->count() > 0)
                                            <div class="mt-4">
                                                <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-3">Available Schedules:</h4>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    @foreach($availableSchedules->take(4) as $schedule)
                                                        <div class="bg-white dark:bg-gray-700 p-4 rounded border">
                                                            <h5 class="font-semibold text-gray-800 dark:text-gray-200">
                                                                {{ $schedule->departure_time->format('M d, g:i A') }}
                                                            </h5>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                                {{ $schedule->origin }} → {{ $schedule->destination }}
                                                            </p>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                                Available seats: {{ $schedule->seats_available - $schedule->ferryTickets->count() }}/{{ $schedule->seats_available }}
                                                            </p>
                                                            <form method="POST" action="{{ route('ferry.tickets.assign-schedule') }}" class="mt-3">
                                                                @csrf
                                                                <input type="hidden" name="ferry_ticket_id" value="{{ $ferryTicket->id }}">
                                                                <input type="hidden" name="ferry_schedule_id" value="{{ $schedule->id }}">
                                                                <button type="submit" class="w-full inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                                    Select This Schedule
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if($availableSchedules->count() > 4)
                                                    <div class="text-center mt-3">
                                                        <p class="text-sm text-yellow-600 dark:text-yellow-400">
                                                            Showing 4 of {{ $availableSchedules->count() }} schedules. 
                                                            <a href="{{ route('visitor.ferry.schedules') }}" class="underline hover:no-underline">View all schedules</a>
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="bg-red-100 dark:bg-red-800/30 p-4 rounded-lg">
                                                <p class="text-red-700 dark:text-red-300">
                                                    No available ferry schedules at the moment. Please check back later or contact our support team.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Ferry Pass section removed -->
                        @endif
                    @endif

                    <!-- Middle Dashboard Images -->
                    @if(isset($dashboardImages['middle']) && $dashboardImages['middle']->count() > 0)
                        <div class="mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($dashboardImages['middle'] as $image)
                                    <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm">
                                        <img src="{{ Storage::url($image->image_path) }}" 
                                             alt="{{ $image->title }}" 
                                             class="w-full h-48 object-cover">
                                        @if($image->title || $image->description)
                                            <div class="p-4">
                                                @if($image->title)
                                                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $image->title }}</h3>
                                                @endif
                                                @if($image->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $image->description }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
                        <!-- Hotel Booking Card -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-lg border border-blue-200 dark:border-blue-700">
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-3">Hotel Accommodations</h3>
                            <p class="text-blue-700 dark:text-blue-300 mb-4">Book your perfect room and enjoy our luxurious accommodations.</p>
                            <div class="space-y-2">
                                <a href="{{ route('rooms.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Book a Room
                                </a>
                                <a href="{{ route('my.bookings') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View My Bookings
                                </a>
                            </div>
                        </div>

                        <!-- Ferry Services Card -->
                        <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-lg border border-green-200 dark:border-green-700">
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-3">Ferry Services</h3>
                            <p class="text-green-700 dark:text-green-300 mb-4">Explore our island destinations with our reliable ferry services.</p>
                            <div class="space-y-2">
                                <a href="{{ route('ferry.request') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Request Ferry Tickets
                                </a>
                                <a href="{{ route('ferry.my-requests') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View My Ferry Tickets
                                </a>
                            </div>
                        </div>

                        <!-- Events Card -->
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-6 rounded-lg border border-purple-200 dark:border-purple-700">
                            <h3 class="text-lg font-semibold text-purple-800 dark:text-purple-200 mb-3">Events & Activities</h3>
                            <p class="text-purple-700 dark:text-purple-300 mb-4">Discover exciting events and activities during your stay.</p>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Browse Events
                            </a>
                        </div>
                    </div>

                    <!-- Bottom Dashboard Images -->
                    @if(isset($dashboardImages['bottom']) && $dashboardImages['bottom']->count() > 0)
                        <div class="mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($dashboardImages['bottom'] as $image)
                                    <div class="bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-sm">
                                        <img src="{{ Storage::url($image->image_path) }}" 
                                             alt="{{ $image->title }}" 
                                             class="w-full h-48 object-cover">
                                        @if($image->title || $image->description)
                                            <div class="p-4">
                                                @if($image->title)
                                                    <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $image->title }}</h3>
                                                @endif
                                                @if($image->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $image->description }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h3 class="text-lg font-semibold mb-3">Quick Actions</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 