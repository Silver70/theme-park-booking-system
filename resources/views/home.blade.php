<x-app-layout>
    <x-navbar />
    {{-- Hero Section --}}
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 py-12 mx-auto lg:gap-8 xl:gap-0 lg:py-20 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-tight md:text-5xl xl:text-6xl text-gray-900 dark:text-white">
                    Escape to Paradise at Our Island Theme Park
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-600 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    Book your room, reserve ferry tickets, and get ready for an unforgettable adventure. Discover fun, relaxation, and natural beauty—all in one place.
                </p>
                <a href="#book-now" class="inline-flex items-center justify-center px-6 py-3 mr-3 text-base font-medium text-white rounded-lg bg-teal-600 hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 dark:focus:ring-teal-800 transition-all">
                    Book Now
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </a>
                <a href="#explore" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-teal-700 border border-teal-400 rounded-lg hover:bg-teal-50 focus:ring-4 focus:ring-teal-200 dark:text-teal-300 dark:border-teal-600 dark:hover:bg-teal-800 dark:focus:ring-teal-800 transition-all">
                    Explore the Island
                </a> 
            </div>
            <div class=" pt-16 lg:mt-0 lg:col-span-5 lg:flex">
                <img src="{{ asset('images/hero-themepark.png') }}" alt="Theme park island illustration">
            </div>                
        </div>
    </section>

   

    {{-- Rooms Section --}}
    <section class="bg-white border-t border-gray-300 dark:bg-gray-900">
        <div class="max-w-screen-xl mx-auto px-4 py-16">
            <div class=" mx-auto mb-12 lg:flex lg:justify-between lg:items-center">
                <div>
                    <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
                        Discover Our Rooms
                    </h2>
                    <p class="mt-4 text-lg sm:text-xl font-medium text-gray-600 dark:text-gray-300">
                        Find the perfect space to relax and enjoy your stay.
                    </p>
                </div>
           
                <a href="/" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition-all">
                    View All Rooms
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
    
            <div class="grid gap-8 sm:grid-cols-1 lg:grid-cols-3">
                @foreach ($rooms as $room)
                    <x-card :room="$room" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ferry Schedule Section --}}
    <section class="bg-gray-50 dark:bg-gray-800 border-t border-gray-300">
        <div class="max-w-screen-xl mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
                    Plan Your Journey
                </h2>
                <p class="mt-4 text-lg sm:text-xl font-medium text-gray-600 dark:text-gray-300">
                    Book your ferry tickets and start your island adventure
                </p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 mb-8">
                <div class="flex flex-wrap gap-4 mb-6">
                    <button class="px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition-all">
                        One Way
                    </button>
                    <button class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all">
                        Round Trip
                    </button>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Departure Date</label>
                        <input type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Number of Passengers</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                            <option>1 Passenger</option>
                            <option>2 Passengers</option>
                            <option>3 Passengers</option>
                            <option>4+ Passengers</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="/" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:ring-4 focus:ring-teal-300 transition-all">
                        View Ferry Schedules
                        <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        </section>

    {{-- Island Attractions Section --}}
    <section class="bg-white dark:bg-gray-900 border-t border-gray-300">
        <div class="max-w-screen-xl mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
                    Island Adventures
                </h2>
                <p class="mt-4 text-lg sm:text-xl font-medium text-gray-600 dark:text-gray-300">
                    Discover endless fun and excitement on our island paradise
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Water Activities -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                      <img src="{{ asset('images/water-sp.jpg') }}" alt="Water Sports" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Water Sports</h3>
                        <p class="text-gray-600 dark:text-gray-300">Snorkeling, diving, kayaking, and paddleboarding in crystal clear waters.</p>
                    </div>
                </div>

                <!-- Theme Park -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-purple-400 to-purple-600  flex items-center justify-center">
                       <img src="{{ asset('images/themepark.jpg') }}" alt="Theme Park" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Theme Park</h3>
                        <p class="text-gray-600 dark:text-gray-300">Thrilling rides, family attractions, and entertainment for all ages.</p>
                    </div>
                </div>

                <!-- Spa & Wellness -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center">
                        <img src="{{ asset('images/spa.webp') }}" alt="Spa & Wellness" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Spa & Wellness</h3>
                        <p class="text-gray-600 dark:text-gray-300">Relaxing treatments, yoga sessions, and wellness programs.</p>
                    </div>
                </div>

                <!-- Beach Activities -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                        <img src="{{ asset('images/beach-act.jpg') }}" alt="Beach Activities" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Beach Activities</h3>
                        <p class="text-gray-600 dark:text-gray-300">Beach volleyball, sunbathing, and sunset watching on pristine shores.</p>
                    </div>
                </div>

                <!-- Dining -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                        <img src="{{ asset('images/dining.jpg') }}" alt="Fine Dining" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Fine Dining</h3>
                        <p class="text-gray-600 dark:text-gray-300">World-class restaurants with local and international cuisine.</p>
                    </div>
                </div>

                <!-- Adventure Tours -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                      <img src="{{ asset('images/adv.jpg') }}" alt="Adventure Tours" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Adventure Tours</h3>
                        <p class="text-gray-600 dark:text-gray-300">Guided hiking, wildlife watching, and island exploration.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="bg-gray-50 dark:bg-gray-800 border-t border-gray-300">
        <div class="max-w-screen-xl mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
                    What Our Guests Say
                </h2>
                <p class="mt-4 text-lg sm:text-xl font-medium text-gray-600 dark:text-gray-300">
                    Real experiences from happy visitors
                </p>
            </div>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"Absolutely magical experience! The rooms were luxurious, the activities were endless, and the staff went above and beyond. Can't wait to return!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-teal-500 rounded-full flex items-center justify-center text-white font-bold text-lg">S</div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Sarah Johnson</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Family Vacation</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"The ferry service was seamless and the island exceeded all expectations. Perfect blend of adventure and relaxation. Highly recommend!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-teal-500 rounded-full flex items-center justify-center text-white font-bold text-lg">M</div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Mike Chen</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Adventure Seeker</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6 italic">"The spa treatments were heavenly and the beachfront dining was spectacular. This island truly offers the perfect escape from everyday life."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-teal-500 rounded-full flex items-center justify-center text-white font-bold text-lg">E</div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Emma Rodriguez</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Wellness Retreat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section class="bg-white dark:bg-gray-900 border-t border-gray-300">
        <div class="max-w-screen-xl mx-auto px-4 py-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight">
                    Island Gallery
                </h2>
                <p class="mt-4 text-lg sm:text-xl font-medium text-gray-600 dark:text-gray-300">
                    Capturing the beauty and excitement of our paradise
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Gallery Item 1 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <img src="{{ asset('images/beach_villa_deluxe.jpg') }}" alt="Beach Villa" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-semibold">Beach Villa Deluxe</h3>
                            <p class="text-sm opacity-90">Luxury accommodation</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 2 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <img src="{{ asset('images/garden_bungalow.jpg') }}" alt="Garden Bungalow" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-semibold">Garden Bungalow</h3>
                            <p class="text-sm opacity-90">Tropical retreat</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 3 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <img src="{{ asset('images/ocean_view_suite.jpg') }}" alt="Ocean View Suite" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-semibold">Ocean View Suite</h3>
                            <p class="text-sm opacity-90">Panoramic views</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 4 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <img src="{{ asset('images/hero-themepark.png') }}" alt="Theme Park" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-semibold">Theme Park</h3>
                            <p class="text-sm opacity-90">Family fun</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 5 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="w-full h-64 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-semibold">Water Activities</h3>
                            <p class="text-sm opacity-90">Adventure awaits</p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Item 6 -->
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300">
                    <div class="w-full h-64 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg font-semibold">Spa & Wellness</h3>
                            <p class="text-sm opacity-90">Relaxation zone</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
    
   
</x-app-layout>