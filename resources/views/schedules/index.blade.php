<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ferry Schedules - {{ config('app.name', 'Theme Park Resort') }}</title>

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
            <!-- Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Ferry Schedules</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">View upcoming ferry departures and plan your journey</p>
                    </div>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                        ← Back to Overview
                    </a>
                </div>
            </div>

            @if($schedules->count() > 0)
                <!-- Schedules Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($schedules as $schedule)
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $schedule->origin }}
                                    </h3>
                                    <div class="flex items-center text-gray-500 dark:text-gray-400 my-2">
                                        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $schedule->destination }}
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        {{ $schedule->departure_time->format('g:i A') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $schedule->departure_time->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Capacity Info -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Availability</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $schedule->fresh_remaining_capacity }} / {{ $schedule->seats_available }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" 
                                         style="width: {{ $schedule->seats_available > 0 ? (($schedule->seats_available - $schedule->fresh_remaining_capacity) / $schedule->seats_available) * 100 : 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Status and Action -->
                            <div class="flex justify-between items-center">
                                @if($schedule->fresh_is_full)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Fully Booked
                                    </span>
                                @elseif($schedule->fresh_remaining_capacity <= 5)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Few Seats Left
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Available
                                    </span>
                                @endif

                                @guest
                                    <button onclick="showLoginPrompt()" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 disabled:opacity-50"
                                            {{ $schedule->fresh_is_full ? 'disabled' : '' }}>
                                        Book Now
                                    </button>
                                @else
                                    @if(Auth::user()->isVisitor())
                                        <a href="{{ route('visitor-dashboard') }}" 
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                            Book Now
                                        </a>
                                    @else
                                        <span class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                                            View Only
                                        </span>
                                    @endif
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $schedules->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No schedules available</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">There are currently no upcoming ferry schedules.</p>
                </div>
            @endif
        </x-sidebar>

        <!-- Login Prompt Modal -->
        @guest
        <div id="loginModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sign In Required</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Please sign in to book ferry tickets and access personalized features.</p>
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
