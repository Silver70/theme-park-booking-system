<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Theme Park Resort') }} - Welcome</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $menuService = new \App\Services\MenuService();
            $menuItems = $menuService->getVisitorMenu();
        @endphp
        
        <x-sidebar :menuItems="$menuItems" title="Theme Park Resort">
            <!-- Hero Section -->
            <div class="mb-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 text-white">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-bold mb-4">Welcome to Paradise Resort</h1>
                    <p class="text-xl mb-6">Discover your perfect tropical getaway with luxurious accommodations, exciting ferry adventures, and unforgettable experiences.</p>
                    @guest
                        <div class="flex space-x-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                                Sign In to Book
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-800 transition duration-200">
                                Create Account
                            </a>
                        </div>
                    @else
                        <div class="flex space-x-4">
                            @if(Auth::user()->isVisitor())
                                <a href="{{ route('visitor-dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                                    Go to My Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                                    Go to Dashboard
                                </a>
                            @endif
                        </div>
                    @endguest
                </div>
            </div>

            <!-- Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            @include('components.icons.rooms', ['class' => 'w-6 h-6 text-blue-600 dark:text-blue-400'])
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $rooms->count() }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">Available Rooms</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            @include('components.icons.calendar', ['class' => 'w-6 h-6 text-green-600 dark:text-green-400'])
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ \App\Models\FerrySchedule::whereNull('cancelled_at')->where('departure_time', '>', now())->count() }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Ferry Schedules</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            @include('components.icons.image', ['class' => 'w-6 h-6 text-purple-600 dark:text-purple-400'])
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ \App\Models\Location::active()->count() }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Locations to Explore</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Accommodations -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Featured Accommodations</h2>
                    <a href="{{ route('rooms.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">View All Rooms →</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($rooms->take(3) as $room)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                @if($room->image)
                                    @if(str_starts_with($room->image, 'http'))
                                        {{-- External URL image --}}
                                        <img src="{{ $room->image }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{-- Uploaded file image --}}
                                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover">
                                    @endif
                                @else
                                    <span class="text-white text-lg font-semibold">{{ $room->name }}</span>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $room->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $room->description }}</p>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $room->formatted_price }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">per night</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('rooms.show', $room->id) }}" 
                                       class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                        View Details
                                    </a>
                                    @guest
                                        <button onclick="showLoginPrompt()" 
                                                class="flex-1 text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                            Book Now
                                        </button>
                                    @else
                                        <a href="{{ route('rooms.index') }}" 
                                           class="flex-1 text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                                            Book Now
                                        </a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ferry Schedules Preview -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Upcoming Ferry Departures</h2>
                    <a href="{{ route('schedules.index') }}" class="text-blue-600 hover:text-blue-700 font-medium">View All Schedules →</a>
                </div>
                
                @php
                    $upcomingSchedules = \App\Models\FerrySchedule::whereNull('cancelled_at')
                        ->where('departure_time', '>', now())
                        ->orderBy('departure_time')
                        ->take(4)
                        ->get();
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($upcomingSchedules as $schedule)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $schedule->origin }} → {{ $schedule->destination }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $schedule->departure_time->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ $schedule->departure_time->format('g:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $schedule->remaining_capacity }} / {{ $schedule->seats_available }} seats available
                                </span>
                                @guest
                                    <button onclick="showLoginPrompt()" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                        Book Ticket
                                    </button>
                                @else
                                    <a href="{{ route('schedules.index') }}" 
                                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                        View Schedules
                                    </a>
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Explore Our Resort -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Explore Our Resort</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Interactive Map -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-4">
                            @include('components.icons.chart', ['class' => 'w-6 h-6 text-blue-600 dark:text-blue-400 mr-3'])
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Interactive Map</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Discover all the amazing locations and attractions across our resort with our interactive map.
                        </p>
                        <div class="h-32 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <span class="text-white font-semibold relative z-10">🗺️ Interactive Resort Map</span>
                        </div>
                        <a href="{{ route('explore-map.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Explore Map
                        </a>
                    </div>

                    <!-- Resort Features -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-4">
                            @include('components.icons.image', ['class' => 'w-6 h-6 text-purple-600 dark:text-purple-400 mr-3'])
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Resort Attractions</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="text-gray-700 dark:text-gray-300">Pristine Beaches & Water Sports</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700 dark:text-gray-300">Luxury Spa & Wellness Center</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                <span class="text-gray-700 dark:text-gray-300">World-Class Dining Experiences</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                <span class="text-gray-700 dark:text-gray-300">Adventure & Entertainment</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            @guest
                                <button onclick="showLoginPrompt()" 
                                        class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                                    Plan Your Visit
                                </button>
                            @else
                                <a href="{{ route('visitor-dashboard') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                                    Plan Your Visit
                                </a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <div class="text-center text-gray-600 dark:text-gray-400">
                    <p>&copy; {{ date('Y') }} Paradise Resort. Experience luxury in paradise.</p>
                </div>
            </footer>
        </x-sidebar>

        <!-- Login Prompt Modal -->
        @guest
        <div id="loginModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sign In Required</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Please sign in or create an account to make bookings and access personalized features.</p>
                    <div class="flex flex-col space-y-3 justify-center">
                        <a href="{{ route('login') }}" 
                           class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                            Create Account
                        </a>
                        <button onclick="closeLoginPrompt()" 
                                class="px-6 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function showLoginPrompt() {
                document.getElementById('loginModal').classList.remove('hidden');
            }

            function closeLoginPrompt() {
                document.getElementById('loginModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            document.getElementById('loginModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLoginPrompt();
                }
            });
        </script>
        @endguest
    </body>
</html>