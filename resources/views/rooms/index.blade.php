<x-app-layout>
    <!-- Navigation Bar -->
    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Available Rooms</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to My Details
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

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-800/30 border border-red-200 dark:border-red-700 rounded-lg">
                    <p class="text-red-700 dark:text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Choose Your Perfect Stay</h1>
                <p class="text-gray-600 dark:text-gray-400">Select from our luxurious accommodations and start your dream vacation.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700">
                            <div class="flex items-center justify-center h-48 bg-gradient-to-br from-blue-400 to-purple-500">
                                <span class="text-white text-lg font-semibold">{{ $room->name }}</span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $room->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $room->description }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $room->formatted_price }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">per night</span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('rooms.show', $room->id) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    View Details
                                </a>
                                <button onclick="openBookingModal({{ $room->id }}, '{{ $room->name }}', {{ $room->price }})"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4" id="modalTitle">Book Room</h3>
                
                <form id="bookingForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Check-in Date</label>
                        <input type="date" id="check_in_date" name="check_in_date" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                    
                    <div class="mb-4">
                        <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Check-out Date</label>
                        <input type="date" id="check_out_date" name="check_out_date" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                               min="{{ date('Y-m-d', strtotime('+2 days')) }}">
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span id="priceDisplay"></span> per night
                        </p>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeBookingModal()"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openBookingModal(roomId, roomName, price) {
            document.getElementById('modalTitle').textContent = `Book ${roomName}`;
            document.getElementById('bookingForm').action = `/rooms/${roomId}/book`;
            document.getElementById('priceDisplay').textContent = `$${price.toFixed(2)}`;
            document.getElementById('bookingModal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });

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
        });
    </script>
</x-app-layout> 