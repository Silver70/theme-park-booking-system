<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Ferry Tickets">
        <div class="flex-1 overflow-hidden">
            <div class="p-6 max-w-4xl mx-auto">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Ferry Ticket Validation</h1>
                    <p class="text-gray-600 mt-2">Verify hotel bookings and issue ferry passes for your guests</p>
                </div>

                <!-- Validation Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-6">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Booking Validation
                        </h2>
                        <p class="text-blue-100 text-sm mt-1">Enter booking details to verify eligibility</p>
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('ferry.tickets.validate.submit') }}" class="space-y-6">
                            @csrf
                            
                            <!-- Search Options -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Booking Reference -->
                                <div class="space-y-2">
                                    <label for="booking_reference" class="block text-sm font-medium text-gray-700">
                                        Hotel Booking Reference
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="booking_reference" 
                                               name="booking_reference" 
                                               value="{{ old('booking_reference') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                               placeholder="e.g., BK001, BK002">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('booking_reference')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Customer Name -->
                                <div class="space-y-2">
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700">
                                        Customer Name
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="customer_name" 
                                               name="customer_name" 
                                               value="{{ old('customer_name') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" 
                                               placeholder="Enter full name">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('customer_name')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Help Text -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            <strong>Search Tips:</strong> You can search by either booking reference (e.g., BK001) or customer name. Both fields are optional, but at least one must be provided.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-center">
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Validate Booking
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-white rounded-xl shadow-lg border border-green-200 overflow-hidden mb-6">
                        <div class="bg-green-50 border-b border-green-200 px-6 py-4">
                            <h3 class="text-lg font-semibold text-green-800 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ferry Pass Issued Successfully
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-gray-700">{{ session('success') }}</p>
                                    <p class="text-sm text-gray-500 mt-2">The customer can now use their ferry pass to board any available ferry schedule.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Validation Results -->
                @if(session('validation_error'))
                    @php
                        $errorMessage = session('validation_error');
                        $isAlreadyIssued = str_contains($errorMessage, 'Ferry pass has already been issued');
                        $headerText = $isAlreadyIssued ? 'Ferry Pass Already Issued' : 'Booking Not Found';
                        $helpText = $isAlreadyIssued 
                            ? 'This booking already has a ferry pass. Each booking can only have one ferry ticket.' 
                            : 'Please check the booking reference or customer name and try again.';
                        $borderColor = $isAlreadyIssued ? 'border-orange-200' : 'border-red-200';
                        $bgColor = $isAlreadyIssued ? 'bg-orange-50' : 'bg-red-50';
                        $textColor = $isAlreadyIssued ? 'text-orange-800' : 'text-red-800';
                        $iconBgColor = $isAlreadyIssued ? 'bg-orange-100' : 'bg-red-100';
                        $iconTextColor = $isAlreadyIssued ? 'text-orange-600' : 'text-red-600';
                    @endphp
                    
                    <div class="bg-white rounded-xl shadow-lg border {{ $borderColor }} overflow-hidden mb-6">
                        <div class="{{ $bgColor }} border-b {{ $borderColor }} px-6 py-4">
                            <h3 class="text-lg font-semibold {{ $textColor }} flex items-center">
                                @if($isAlreadyIssued)
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                @endif
                                {{ $headerText }}
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full {{ $iconBgColor }}">
                                        @if($isAlreadyIssued)
                                            <svg class="h-6 w-6 {{ $iconTextColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        @else
                                            <svg class="h-6 w-6 {{ $iconTextColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-gray-700">{{ $errorMessage }}</p>
                                    <p class="text-sm text-gray-500 mt-2">{{ $helpText }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('booking'))
                    <div class="bg-white rounded-xl shadow-lg border border-green-200 overflow-hidden mb-6">
                        <div class="bg-green-50 border-b border-green-200 px-6 py-4">
                            <h3 class="text-lg font-semibold text-green-800 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Valid Booking Found
                            </h3>
                        </div>
                        <div class="p-6">
                            @php $booking = session('booking'); @endphp
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-900">Booking Details</h4>
                                    <div class="space-y-2">
                                        <p class="text-sm"><span class="font-medium text-gray-700">Booking ID:</span> <span class="text-gray-900">{{ $booking->id }}</span></p>
                                        <p class="text-sm"><span class="font-medium text-gray-700">Customer:</span> <span class="text-gray-900">{{ $booking->user->name }}</span></p>
                                        <p class="text-sm"><span class="font-medium text-gray-700">Email:</span> <span class="text-gray-900">{{ $booking->user->email }}</span></p>
                                        <p class="text-sm"><span class="font-medium text-gray-700">Check-in:</span> <span class="text-gray-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span></p>
                                        <p class="text-sm"><span class="font-medium text-gray-700">Check-out:</span> <span class="text-gray-900">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span></p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <h4 class="font-semibold text-gray-900">Validation Status</h4>
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100">
                                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-green-700 font-medium">Eligible for Ferry Pass</span>
                                    </div>
                                    <div class="pt-4">
                                        <form method="POST" action="{{ route('ferry.tickets.issue') }}">
                                            @csrf
                                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-200 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                                </svg>
                                                Issue Ferry Pass
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Instructions Panel -->
                <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">How to Use Ferry Ticket Validation</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mx-auto mb-3">
                                <span class="text-blue-600 font-bold text-lg">1</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Search Booking</h4>
                            <p class="text-sm text-gray-600">Enter either the hotel booking reference or customer name to locate the reservation.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mx-auto mb-3">
                                <span class="text-blue-600 font-bold text-lg">2</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Verify Details</h4>
                            <p class="text-sm text-gray-600">Review the booking information and confirm the customer's eligibility for ferry services.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mx-auto mb-3">
                                <span class="text-blue-600 font-bold text-lg">3</span>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-2">Issue Pass</h4>
                            <p class="text-sm text-gray-600">Click "Issue Ferry Pass" to generate and provide the customer with their ferry ticket.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-sidebar>
</x-app-layout>