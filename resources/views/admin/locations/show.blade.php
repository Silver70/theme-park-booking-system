<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Location Details">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Location Details</h1>
                    <p class="text-gray-600 dark:text-gray-400">View location information and coordinates</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.locations.edit', $location) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Edit Location
                    </a>
                    <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← Back to Locations
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Location Information -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Location Information</h3>
                    
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $location->name }}</p>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Type</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ str_replace('_', ' ', $location->type) }}</p>
                        </div>

                        <!-- Description -->
                        @if($location->description)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $location->description }}</p>
                            </div>
                        @endif

                        <!-- Icon Color -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Icon Color</label>
                            <div class="mt-1 flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-full border border-gray-300 dark:border-gray-600" style="background-color: {{ $location->icon_color }}"></div>
                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $location->icon_color }}</span>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <div class="mt-1">
                                @if($location->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Display Order -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Display Order</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $location->display_order }}</p>
                        </div>

                        <!-- Created/Updated -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $location->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $location->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map and Coordinates -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Location on Map</h3>
                    
                    <div class="space-y-4">
                        <!-- Coordinates -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Coordinates</label>
                            <div class="mt-1 grid grid-cols-2 gap-2">
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Latitude</span>
                                    <p class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $location->latitude }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Longitude</span>
                                    <p class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $location->longitude }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Map Preview</label>
                            <div id="map" class="mt-2 w-full h-48 rounded-lg border border-gray-200 dark:border-gray-700"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Actions</h3>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.locations.edit', $location) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Location
                    </a>

                    <form method="POST" action="{{ route('admin.locations.toggle-status', $location) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        @if($location->is_active)
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                Deactivate
                            </button>
                        @else
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Activate
                            </button>
                        @endif
                    </form>

                    <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this location? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Location
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- OpenStreetMap with Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        
        <script>
            function initMap() {
                // Initialize the map centered on the location
                const map = L.map('map').setView([{{ $location->latitude }}, {{ $location->longitude }}], 16);
                
                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Add marker for the location
                const marker = L.marker([{{ $location->latitude }}, {{ $location->longitude }}], {
                    title: "{{ $location->name }}"
                }).addTo(map);

                // Create custom marker icon with color
                const customIcon = L.divIcon({
                    html: `<div style="background-color: {{ $location->icon_color }}; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">📍</div>`,
                    className: 'custom-marker',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                
                marker.setIcon(customIcon);

                // Create popup content
                const popupContent = `
                    <div style="padding: 5px; min-width: 150px;">
                        <h3 style="margin: 0 0 5px 0; color: #1F2937; font-weight: 600; font-size: 14px;">{{ $location->name }}</h3>
                        <p style="margin: 0; color: #6B7280; font-size: 12px;">{{ str_replace('_', ' ', $location->type) }}</p>
                        @if($location->description)
                            <p style="margin: 5px 0 0 0; color: #6B7280; font-size: 11px;">{{ $location->description }}</p>
                        @endif
                    </div>
                `;

                marker.bindPopup(popupContent);
            }

            // Initialize map when page loads
            document.addEventListener('DOMContentLoaded', function() {
                initMap();
            });
        </script>
    </x-sidebar>
</x-app-layout>
