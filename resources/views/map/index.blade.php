<x-app-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Resort Map</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Explore our resort locations, restaurants, activities, and points of interest</p>
                    </div>
                    <a href="{{ route('visitor-dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Map -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Interactive Map</h2>
                        <div class="relative">
                            <div id="map" class="w-full h-96 rounded-lg border border-gray-200 dark:border-gray-700"></div>
                            <div class="absolute top-2 right-2 bg-white dark:bg-gray-800 px-2 py-1 rounded text-xs text-gray-600 dark:text-gray-400 shadow-sm">
                                <span id="coordinates">Click to explore</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location List -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Locations</h2>
                        
                        @if($locations->count() > 0)
                            <div class="space-y-3">
                                @foreach($locations as $location)
                                    <div class="p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer" 
                                         onclick="focusLocation({{ $location->latitude }}, {{ $location->longitude }}, '{{ $location->name }}')">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-4 h-4 rounded-full mt-1" style="background-color: {{ $location->icon_color }}"></div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $location->name }}</h3>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ str_replace('_', ' ', $location->type) }}</p>
                                                @if($location->description)
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $location->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">No locations available</p>
                                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Check back later for updates</p>
                            </div>
                        @endif
                    </div>

                    <!-- Map Legend -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Map Legend</h3>
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Resort</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Restaurant</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Activity</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-purple-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Point of Interest</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Transport</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- OpenStreetMap with Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        let map, markers = [];

        function initMap() {
            // Default center (Maldives)
            const defaultCenter = [4.173595, 73.485471];
            
            // Create the map
            map = L.map('map').setView(defaultCenter, 13);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add markers for all locations
            @foreach($locations as $location)
                const marker{{ $location->id }} = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
                    title: "{{ $location->name }}"
                }).addTo(map);

                // Store marker reference
                markers.push(marker{{ $location->id }});

                // Create custom marker icon with color
                const customIcon{{ $location->id }} = L.divIcon({
                    html: `<div style="background-color: {{ $location->icon_color }}; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">📍</div>`,
                    className: 'custom-marker',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                
                marker{{ $location->id }}.setIcon(customIcon{{ $location->id }});

                // Create popup content
                const popupContent{{ $location->id }} = `
                    <div style="padding: 10px; max-width: 250px;">
                        <h3 style="margin: 0 0 8px 0; color: #1F2937; font-weight: 600; font-size: 16px;">{{ $location->name }}</h3>
                        <p style="margin: 0 0 5px 0; color: #6B7280; font-size: 14px; text-transform: capitalize;">{{ str_replace('_', ' ', $location->type) }}</p>
                        @if($location->description)
                            <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 13px; line-height: 1.4;">{{ $location->description }}</p>
                        @endif
                    </div>
                `;

                marker{{ $location->id }}.bindPopup(popupContent{{ $location->id }});
            @endforeach

            // Update coordinates display on map click
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;
                document.getElementById("coordinates").textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            });

            // Center map on first location if available
            @if($locations->count() > 0)
                const firstLocation = [{{ $locations->first()->latitude }}, {{ $locations->first()->longitude }}];
                map.setView(firstLocation, 16);
            @endif
        }

        // Function to focus on a specific location
        function focusLocation(lat, lng, name) {
            const position = [lat, lng];
            map.setView(position, 16);
            
            // Find and open popup for this location
            const marker = markers.find(m => {
                const pos = m.getLatLng();
                return pos.lat === lat && pos.lng === lng;
            });
            
            if (marker) {
                marker.openPopup();
            }
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
        });
    </script>
</x-app-layout>
