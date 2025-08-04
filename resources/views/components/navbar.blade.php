<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center bg-white">
                <a href="/" class="flex items-center space-x-2 bg-white">
                    <img src="{{ asset('svg/theme-logo.svg') }}" alt="TravelHub" class="w-10 h-10 bg-white">
                    <span class="text-xl font-bold text-gray-800 bg-white">TravelHub</span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                     <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{route('hotel.booking')}}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 flex items-center space-x-1">
                    <i class="fas fa-bed text-sm"></i>
                    <span>Hotels</span>
                </a>
                <a href="/ferry-tickets" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 flex items-center space-x-1">
                    <i class="fas fa-ship text-sm"></i>
                    <span>Ferry Tickets</span>
                </a>
                <a href="/events" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 flex items-center space-x-1">
                    <i class="fas fa-calendar-alt text-sm"></i>
                    <span>Events</span>
                </a>
                <a href="/maps" class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200 flex items-center space-x-1">
                    <i class="fas fa-map text-sm"></i>
                    <span>Maps</span>
                </a>
            </div>
            
            <!-- CTA Button & Mobile Menu Button -->
            <div class="flex items-center gap-4">
                <!-- Login Button -->
                <a href="{{route('login')}}" class="bg-teal-500 text-white px-6 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                    Login
                </a>
                <a href="{{ route('register') }}"
                class="bg-teal-100 text-teal-800 px-6 py-2 rounded-lg font-medium border border-teal-200 hover:bg-teal-200 transition-all duration-200 shadow-sm hover:shadow-md">
                Register
             </a>
             
             
             
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            </div>
        
        </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-100">
        <div class="px-4 py-3 space-y-3">
            <a href="/hotels" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600 py-2 transition-colors duration-200">
                <i class="fas fa-bed text-blue-500 w-5"></i>
                <span class="font-medium">Hotels</span>
            </a>
            <a href="/ferry-tickets" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600 py-2 transition-colors duration-200">
                <i class="fas fa-ship text-blue-500 w-5"></i>
                <span class="font-medium">Ferry Tickets</span>
            </a>
            <a href="/events" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600 py-2 transition-colors duration-200">
                <i class="fas fa-calendar-alt text-blue-500 w-5"></i>
                <span class="font-medium">Events</span>
            </a>
            <a href="/maps" class="flex items-center space-x-3 text-gray-700 hover:text-blue-600 py-2 transition-colors duration-200">
                <i class="fas fa-map text-blue-500 w-5"></i>
                <span class="font-medium">Maps</span>
            </a>
        </div>
    </div>
</nav>