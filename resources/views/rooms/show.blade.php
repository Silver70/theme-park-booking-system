<x-app-layout>
    <!-- Navigation Bar -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $room->name }}</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to All Rooms
                    </a>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        My Details
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-800/30 border border-green-200 dark:border-green-700 rounded-lg">
                    <p class="text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-800/30 border border-red-200 dark:border-red-700 rounded-lg">
                    <ul class="text-red-700 dark:text-red-300">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Room Image and Details -->
                        <div>
                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-6">
                                <div class="flex items-center justify-center h-64 bg-gradient-to-br from-blue-400 to-purple-500">
                                    <span class="text-white text-2xl font-semibold">{{ $room->name }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $room->name }}</h1>
                                <p class="text-lg text-gray-600 dark:text-gray-400">{{ $room->description }}</p>
                                
                                <div class="flex items-center space-x-4">
                                    <span class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $room->formatted_price }}</span>
                                    <span class="text-gray-500 dark:text-gray-400">per night</span>
                                </div>
                                
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Amenities</h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Air Conditioning</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Free WiFi</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Ocean View</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-600 dark:text-gray-400">Private Bathroom</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Form -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Book This Room</h2>
                            
                            <form method="POST" action="{{ route('rooms.book', $room->id) }}">
                                @csrf
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Check-in Date</label>
                                        <input type="date" id="check_in_date" name="check_in_date" required
                                               value="{{ old('check_in_date') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    
                                    <div>
                                        <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Check-out Date</label>
                                        <input type="date" id="check_out_date" name="check_out_date" required
                                               value="{{ old('check_out_date') }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white"
                                               min="{{ date('Y-m-d', strtotime('+2 days')) }}">
                                    </div>
                                    
                                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-gray-600 dark:text-gray-400">Price per night:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $room->formatted_price }}</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-gray-600 dark:text-gray-400">Number of nights:</span>
                                            <span class="font-semibold text-gray-900 dark:text-gray-100" id="nightsCount">-</span>
                                        </div>
                                        <div class="border-t border-gray-200 dark:border-gray-600 pt-2">
                                            <div class="flex justify-between items-center">
                                                <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total:</span>
                                                <span class="text-lg font-bold text-green-600 dark:text-green-400" id="totalPrice">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button type="submit"
                                            class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-150">
                                        Confirm Booking
                                    </button>
                                </div>
                            </form>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('rooms.index') }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    ← Back to All Rooms
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculateTotal() {
            const checkIn = document.getElementById('check_in_date').value;
            const checkOut = document.getElementById('check_out_date').value;
            const pricePerNight = {{ $room->price }};
            
            if (checkIn && checkOut) {
                const start = new Date(checkIn);
                const end = new Date(checkOut);
                const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                
                if (nights > 0) {
                    document.getElementById('nightsCount').textContent = nights;
                    document.getElementById('totalPrice').textContent = '$' + (nights * pricePerNight).toFixed(2);
                } else {
                    document.getElementById('nightsCount').textContent = '-';
                    document.getElementById('totalPrice').textContent = '-';
                }
            }
        }

        // Update check-out minimum date when check-in date changes
        document.getElementById('check_in_date').addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(nextDay.getDate() + 1);
            
            document.getElementById('check_out_date').min = nextDay.toISOString().split('T')[0];
            
            // If current check-out date is before new minimum, update it
            const currentCheckOut = document.getElementById('check_out_date').value;
            if (currentCheckOut && new Date(currentCheckOut) <= checkInDate) {
                document.getElementById('check_out_date').value = nextDay.toISOString().split('T')[0];
            }
            
            calculateTotal();
        });

        document.getElementById('check_out_date').addEventListener('change', calculateTotal);

        // Calculate total on page load
        calculateTotal();
    </script>
</x-app-layout> 