<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Explore Map - {{ config('app.name', 'Theme Park Resort') }}</title>

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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Resort Map</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Explore all the amazing locations and attractions across our resort</p>
                    </div>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                        ← Back to Overview
                    </a>
                </div>
            </div>

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
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No locations available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-sidebar>

        <!-- Map Scripts -->
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
                        <div class="p-2">
                            <h3 class="font-semibold text-gray-900">${{ json_encode($location->name) }}</h3>
                            <p class="text-sm text-gray-600 capitalize">${{ json_encode(str_replace('_', ' ', $location->type)) }}</p>
                            @if($location->description)
                                <p class="text-xs text-gray-500 mt-1">${{ json_encode($location->description) }}</p>
                            @endif
                        </div>
                    `;
                    
                    marker{{ $location->id }}.bindPopup(popupContent{{ $location->id }});

                    // Add click event to show coordinates
                    marker{{ $location->id }}.on('click', function(e) {
                        document.getElementById('coordinates').textContent = 
                            `${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
                    });
                @endforeach

                // Add map click event
                map.on('click', function(e) {
                    document.getElementById('coordinates').textContent = 
                        `${e.latlng.lat.toFixed(6)}, ${e.latlng.lng.toFixed(6)}`;
                });
            }

            function focusLocation(lat, lng, name) {
                map.setView([lat, lng], 16);
                document.getElementById('coordinates').textContent = `${name} - ${lat}, ${lng}`;
            }

            // Initialize map when page loads
            document.addEventListener('DOMContentLoaded', function() {
                initMap();
            });
        </script>
    </body>
</html>
