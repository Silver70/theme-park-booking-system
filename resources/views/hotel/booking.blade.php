<x-app-layout>
    <x-navbar />
    
    <div class="min-h-screen bg-gray-50">
        <!-- Header Section -->
       

        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Progress Indicator -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                <div class="flex items-center justify-between">
                    <!-- Step 1: Dates & Guests -->
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-semibold">
                            1
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Dates & Guests</p>
                            <p class="text-xs text-gray-500">Select your stay details</p>
                        </div>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 mx-4">
                        <div class="h-1 bg-gray-200 rounded-full">
                            <div class="h-1 bg-blue-600 rounded-full w-1/3"></div>
                        </div>
                    </div>
                    
                    <!-- Step 2: Room Selection -->
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-semibold">
                            2
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Choose Room</p>
                            <p class="text-xs text-gray-400">Select your accommodation</p>
                        </div>
                    </div>
                    
                    <!-- Progress Line -->
                    <div class="flex-1 mx-4">
                        <div class="h-1 bg-gray-200 rounded-full">
                            <div class="h-1 bg-gray-200 rounded-full w-0"></div>
                        </div>
                    </div>
                    
                    <!-- Step 3: Confirmation -->
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 font-semibold">
                            3
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-500">Confirm</p>
                            <p class="text-xs text-gray-400">Review & book</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step Content -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Step 1: Dates & Guests -->
                <div id="step-1" class="step-content">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6">
                        <h2 class="text-2xl font-semibold text-white">Step 1: Select Your Dates & Guests</h2>
                        <p class="text-blue-100 mt-2">Tell us about your stay</p>
                    </div>
                    
                    <div class="p-8">
                        <form id="booking-form">
                            <!-- Date Selection -->
                            <div class="grid md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Check-in Date
                                    </label>
                                    <input type="date" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           min="{{ date('Y-m-d') }}">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Check-out Date
                                    </label>
                                    <input type="date" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                            </div>

                            <!-- Guest Information -->
                            <div class="grid md:grid-cols-3 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Adults
                                    </label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="1">1 Adult</option>
                                        <option value="2" selected>2 Adults</option>
                                        <option value="3">3 Adults</option>
                                        <option value="4">4 Adults</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        Children
                                    </label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="0" selected>0 Children</option>
                                        <option value="1">1 Child</option>
                                        <option value="2">2 Children</option>
                                        <option value="3">3 Children</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                        </svg>
                                        Rooms
                                    </label>
                                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="1" selected>1 Room</option>
                                        <option value="2">2 Rooms</option>
                                        <option value="3">3 Rooms</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Special Requests -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                    Special Requests (Optional)
                                </label>
                                <textarea rows="3" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                          placeholder="Any special requests or preferences?"></textarea>
                            </div>

                            <!-- Navigation -->
                            <div class="flex justify-end">
                                <button type="button" 
                                        onclick="nextStep()"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
                                    Next Step
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Step 2: Room Selection -->
                <div id="step-2" class="step-content hidden">
                    <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-8 py-6">
                        <h2 class="text-2xl font-semibold text-white">Step 2: Choose Your Room</h2>
                        <p class="text-green-100 mt-2">Select from our available accommodations</p>
                    </div>
                    
                    <div class="p-8">
                        <div class="space-y-6">
                            @foreach($rooms ?? [] as $room)
                            <div class="room-card bg-white border-2 border-gray-200 rounded-xl overflow-hidden hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer">
                                <div class="flex flex-col md:flex-row">
                                    <!-- Room Image -->
                                    <div class="md:w-1/3 h-64 md:h-auto">
                                        <img src="{{ asset('images/' . $room->image) }}" 
                                             alt="{{ $room->name }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    
                                    <!-- Room Details -->
                                    <div class="md:w-2/3 p-6 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between mb-3">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $room->name }}</h3>
                                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $room->description }}</p>
                                                </div>
                                                <div class="flex items-center space-x-1 ml-4">
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <span class="text-sm text-gray-600">4.8</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Room Features -->
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Ocean View
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Balcony
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    King Bed
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Price and Selection -->
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                            <div class="flex items-baseline space-x-2">
                                                <span class="text-3xl font-bold text-blue-600">${{ number_format($room->price) }}</span>
                                                <span class="text-gray-500">/night</span>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <input type="radio" name="selected_room" value="{{ $room->id }}" class="w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <span class="text-sm font-medium text-gray-700">Select Room</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between mt-8">
                            <button type="button" 
                                    onclick="prevStep()"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>
                            <button type="button" 
                                    onclick="nextStep()"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
                                Next Step
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Confirmation -->
                <div id="step-3" class="step-content hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-700 px-8 py-6">
                        <h2 class="text-2xl font-semibold text-white">Step 3: Confirm Your Booking</h2>
                        <p class="text-purple-100 mt-2">Review your selection and complete your reservation</p>
                    </div>
                    
                    <div class="p-8">
                        <!-- Booking Summary -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Room Rate (per night)</span>
                                    <span class="font-medium">$280.00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Number of Nights</span>
                                    <span class="font-medium">2</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Taxes & Fees</span>
                                    <span class="font-medium">$56.00</span>
                                </div>
                                <hr class="my-3">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span>Total</span>
                                    <span class="text-blue-600">$616.00</span>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between">
                            <button type="button" 
                                    onclick="prevStep()"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>
                            <button type="button" 
                                    class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Confirm Booking
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        let currentStep = 1;
        const totalSteps = 3;

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            
            // Show current step
            document.getElementById(`step-${step}`).classList.remove('hidden');
            
            // Update progress indicator
            updateProgress(step);
        }

        function updateProgress(step) {
            const progressBars = document.querySelectorAll('.h-1.bg-blue-600');
            const stepCircles = document.querySelectorAll('.w-10.h-10');
            const stepTexts = document.querySelectorAll('.text-sm.font-medium');
            
            // Reset all
            stepCircles.forEach((circle, index) => {
                if (index + 1 <= step) {
                    circle.classList.remove('bg-gray-300', 'text-gray-600');
                    circle.classList.add('bg-blue-600', 'text-white');
                } else {
                    circle.classList.remove('bg-blue-600', 'text-white');
                    circle.classList.add('bg-gray-300', 'text-gray-600');
                }
            });
            
            stepTexts.forEach((text, index) => {
                if (index + 1 <= step) {
                    text.classList.remove('text-gray-500');
                    text.classList.add('text-gray-900');
                } else {
                    text.classList.remove('text-gray-900');
                    text.classList.add('text-gray-500');
                }
            });
            
            // Update progress bars
            progressBars[0].style.width = `${(step / totalSteps) * 100}%`;
            progressBars[1].style.width = `${Math.max(0, (step - 2) / totalSteps) * 100}%`;
        }

        function nextStep() {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // Initialize
        showStep(1);
    </script>
</x-app-layout>