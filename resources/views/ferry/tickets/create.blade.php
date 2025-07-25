<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Tickets">
        <div class="flex-1 overflow-hidden">
            <div class="p-6 max-w-4xl mx-auto">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Issue Ferry Ticket</h1>
                    <p class="text-gray-600 mt-2">Create ferry passes by selecting bookings and schedules</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-white rounded-xl shadow-lg border border-green-200 overflow-hidden mb-6">
                        <div class="bg-green-50 border-b border-green-200 px-6 py-4">
                            <h3 class="text-lg font-semibold text-green-800 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ferry Ticket Created Successfully
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-gray-700">{{ session('success') }}</p>
                                    <p class="text-sm text-gray-500 mt-2">The ferry ticket has been issued and the customer can now board the selected ferry.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Create Ticket Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                            </svg>
                            Ticket Creation Form
                        </h2>
                        <p class="text-blue-100 text-sm mt-1">Select booking and schedule to issue ferry pass</p>
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('ferry.tickets.store') }}" class="space-y-6">
                            @csrf

                            <!-- Booking Selection -->
                            <div class="space-y-2">
                                <label for="booking_id" class="block text-sm font-medium text-gray-700">
                                    Select Hotel Booking *
                                </label>
                                <div class="relative">
                                    <select id="booking_id" 
                                            name="booking_id" 
                                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            required>
                                        <option value="">Choose a booking...</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}" 
                                                    {{ old('booking_id') == $booking->id ? 'selected' : '' }}
                                                    data-customer="{{ $booking->user->name }}"
                                                    data-email="{{ $booking->user->email }}"
                                                    data-checkin="{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}"
                                                    data-checkout="{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}">
                                                Booking #{{ $booking->id }} - {{ $booking->user->name }} ({{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('booking_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Booking Details Preview -->
                            <div id="booking-details" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h4 class="font-medium text-gray-900 mb-3">Booking Details</h4>
                                <div class="grid md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700">Customer:</span>
                                        <span id="customer-name" class="text-gray-900 ml-1"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Email:</span>
                                        <span id="customer-email" class="text-gray-900 ml-1"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Check-in:</span>
                                        <span id="checkin-date" class="text-gray-900 ml-1"></span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">Check-out:</span>
                                        <span id="checkout-date" class="text-gray-900 ml-1"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Ferry Schedule Selection -->
                            <div class="space-y-2">
                                <label for="ferry_schedule_id" class="block text-sm font-medium text-gray-700">
                                    Select Ferry Schedule *
                                </label>
                                <div class="relative">
                                    <select id="ferry_schedule_id" 
                                            name="ferry_schedule_id" 
                                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            required>
                                        <option value="">Choose a ferry schedule...</option>
                                        @foreach($schedules as $schedule)
                                            @php
                                                $ticketCount = \App\Models\FerryTicket::where('ferry_schedule_id', $schedule->id)->count();
                                                $remainingCapacity = $schedule->seats_available - $ticketCount;
                                                $capacityDisplay = $ticketCount . '/' . $schedule->seats_available;
                                            @endphp
                                            <option value="{{ $schedule->id }}" {{ old('ferry_schedule_id') == $schedule->id ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y - g:i A') }} | 
                                                {{ $schedule->origin }} → {{ $schedule->destination }} | 
                                                Capacity: {{ $capacityDisplay }} | 
                                                {{ $remainingCapacity }} seats remaining
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('ferry_schedule_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ticket Price -->
                            <div class="space-y-2">
                                <label for="price" class="block text-sm font-medium text-gray-700">
                                    Ticket Price (USD) *
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="price" 
                                           name="price" 
                                           value="{{ old('price', '35.00') }}"
                                           step="0.01"
                                           min="0"
                                           max="200"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                           placeholder="35.00"
                                           required>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-sm">$</span>
                                    </div>
                                </div>
                                @error('price')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Information Panel -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Note:</strong> Only bookings without existing ferry tickets are shown. Once created, the ticket will be immediately available for the customer to use.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center pt-4">
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                    Issue Ferry Ticket
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- No Data Messages -->
                @if($bookings->isEmpty())
                    <div class="bg-white rounded-xl shadow-lg border border-yellow-200 overflow-hidden mb-6">
                        <div class="bg-yellow-50 border-b border-yellow-200 px-6 py-4">
                            <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                No Available Bookings
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">All current bookings already have ferry tickets assigned. New tickets can only be created for bookings without existing ferry passes.</p>
                        </div>
                    </div>
                @endif

                @if($schedules->isEmpty())
                    <div class="bg-white rounded-xl shadow-lg border border-yellow-200 overflow-hidden mb-6">
                        <div class="bg-yellow-50 border-b border-yellow-200 px-6 py-4">
                            <h3 class="text-lg font-semibold text-yellow-800 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                No Available Schedules
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">No future ferry schedules are available. Please create new schedules before issuing tickets.</p>
                        </div>
                    </div>
                @endif

                <!-- Instructions Panel -->
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">How to Issue Ferry Tickets</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mx-auto mb-3">
                                <span class="text-blue-600 font-bold text-lg">1</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Select Booking</h4>
                            <p class="text-sm text-gray-600">Choose from available hotel bookings that don't have existing ferry tickets.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mx-auto mb-3">
                                <span class="text-blue-600 font-bold text-lg">2</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Choose Schedule</h4>
                            <p class="text-sm text-gray-600">Select the appropriate ferry departure time and route for the customer.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mx-auto mb-3">
                                <span class="text-blue-600 font-bold text-lg">3</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Set Price & Issue</h4>
                            <p class="text-sm text-gray-600">Enter the ticket price and create the ferry pass for immediate use.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar>

    <!-- JavaScript for booking details preview -->
    <script>
        document.getElementById('booking_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const detailsDiv = document.getElementById('booking-details');
            
            if (selectedOption.value) {
                document.getElementById('customer-name').textContent = selectedOption.dataset.customer;
                document.getElementById('customer-email').textContent = selectedOption.dataset.email;
                document.getElementById('checkin-date').textContent = selectedOption.dataset.checkin;
                document.getElementById('checkout-date').textContent = selectedOption.dataset.checkout;
                detailsDiv.classList.remove('hidden');
            } else {
                detailsDiv.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>