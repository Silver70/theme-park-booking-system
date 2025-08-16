<x-app-layout>
    <x-sidebar :menuItems="$menuItems" title="Add New Location">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add New Location</h1>
                    <p class="text-gray-600 dark:text-gray-400">Create a new location with coordinates and details</p>
                </div>
                <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    ← Back to Locations
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Create Form -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('admin.locations.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Location Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Location Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location Type</label>
                            <select name="type" id="type" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Select a type</option>
                                <option value="resort" {{ old('type') == 'resort' ? 'selected' : '' }}>Resort</option>
                                <option value="restaurant" {{ old('type') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                <option value="activity" {{ old('type') == 'activity' ? 'selected' : '' }}>Activity</option>
                                <option value="point_of_interest" {{ old('type') == 'point_of_interest' ? 'selected' : '' }}>Point of Interest</option>
                                <option value="transport" {{ old('type') == 'transport' ? 'selected' : '' }}>Transport</option>
                            </select>
                        </div>

                        <!-- Icon Color -->
                        <div>
                            <label for="icon_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Icon Color</label>
                            <input type="color" name="icon_color" id="icon_color" value="{{ old('icon_color', '#EF4444') }}" required
                                class="w-full h-10 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Latitude</label>
                            <input type="number" name="latitude" id="latitude" step="0.000001" value="{{ old('latitude', '4.173595') }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Longitude</label>
                            <input type="number" name="longitude" id="longitude" step="0.000001" value="{{ old('longitude', '73.485471') }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Display Order -->
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Order</label>
                            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', '1') }}" min="1" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="is_active" id="is_active" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Optional description of the location</p>
                        </div>
                    </div>

                    <!-- Map for coordinate selection -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Map - Click to set coordinates</label>
                        <div id="map" class="w-full h-64 rounded-lg border border-gray-200 dark:border-gray-700"></div>
                        <div class="mt-2 space-y-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">📍 <strong>Click anywhere on the map</strong> to automatically set latitude and longitude coordinates</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">The red marker will move to your selected location and update the form fields above</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.locations.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create Location
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- OpenStreetMap with Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        
        <script>
            function initMap() {
                // Initialize the map centered on default location (Maldives)
                const map = L.map('map').setView([4.173595, 73.485471], 13);
                
                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Add marker for coordinate selection
                const marker = L.marker([4.173595, 73.485471], {
                    title: "Click to set location"
                }).addTo(map);

                // Create custom marker icon with color
                const customIcon = L.divIcon({
                    html: `<div style="background-color: #EF4444; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">📍</div>`,
                    className: 'custom-marker',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });
                
                marker.setIcon(customIcon);

                // Handle map clicks to update coordinates
                map.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    
                    // Update form fields
                    const latInput = document.getElementById('latitude');
                    const lngInput = document.getElementById('longitude');
                    
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    
                    // Move marker to new position
                    marker.setLatLng([lat, lng]);
                    
                    // Visual feedback - highlight the updated fields
                    latInput.style.borderColor = '#10B981';
                    lngInput.style.borderColor = '#10B981';
                    
                    // Show success message
                    showCoordinateUpdateMessage(`Coordinates updated to: ${lat.toFixed(6)}, ${lng.toFixed(6)}`);
                    
                    // Reset border color after 2 seconds
                    setTimeout(() => {
                        latInput.style.borderColor = '';
                        lngInput.style.borderColor = '';
                    }, 2000);
                });
                
                // Function to show coordinate update message
                function showCoordinateUpdateMessage(message) {
                    // Remove existing message if any
                    const existingMessage = document.getElementById('coordinate-message');
                    if (existingMessage) {
                        existingMessage.remove();
                    }
                    
                    // Create new message
                    const messageDiv = document.createElement('div');
                    messageDiv.id = 'coordinate-message';
                    messageDiv.className = 'mt-2 p-2 bg-green-100 border border-green-400 text-green-700 rounded text-sm';
                    messageDiv.textContent = message;
                    
                    // Insert after the map
                    const mapContainer = document.getElementById('map');
                    mapContainer.parentNode.insertBefore(messageDiv, mapContainer.nextSibling);
                    
                    // Auto-remove after 3 seconds
                    setTimeout(() => {
                        if (messageDiv.parentNode) {
                            messageDiv.remove();
                        }
                    }, 3000);
                }

                // Update marker color when color picker changes
                document.getElementById('icon_color').addEventListener('change', function(e) {
                    const color = e.target.value;
                    const newIcon = L.divIcon({
                        html: `<div style="background-color: ${color}; width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">📍</div>`,
                        className: 'custom-marker',
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    });
                    marker.setIcon(newIcon);
                });
            }

            // Initialize map when page loads
            document.addEventListener('DOMContentLoaded', function() {
                initMap();
            });
        </script>
    </x-sidebar>
</x-app-layout>
