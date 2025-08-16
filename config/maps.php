<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for Google Maps integration
    | including API keys and default locations.
    |
    */

    'google_maps' => [
        /*
        |--------------------------------------------------------------------------
        | Google Maps API Key
        |--------------------------------------------------------------------------
        |
        | Your Google Maps JavaScript API key. You can get one from:
        | https://console.cloud.google.com/apis/credentials
        |
        | Note: For production, set this in your .env file as GOOGLE_MAPS_API_KEY
        |
        */
        'api_key' => env('GOOGLE_MAPS_API_KEY', 'YOUR_GOOGLE_MAPS_API_KEY'),

        /*
        |--------------------------------------------------------------------------
        | Default Resort Location
        |--------------------------------------------------------------------------
        |
        | Default coordinates for the resort. You can change these to match
        | your actual resort location.
        |
        */
        'default_location' => [
            'lat' => env('RESORT_LATITUDE', 4.173595),  // Maldives area as example
            'lng' => env('RESORT_LONGITUDE', 73.485471),
            'name' => env('RESORT_NAME', 'Paradise Island Resort'),
            'address' => env('RESORT_ADDRESS', '123 Paradise Beach Road, Island Resort District, Paradise Island, PI 12345'),
            'zoom' => env('MAP_ZOOM_LEVEL', 15),
        ],

        /*
        |--------------------------------------------------------------------------
        | Map Settings
        |--------------------------------------------------------------------------
        |
        | Default map configuration options.
        |
        */
        'map_settings' => [
            'map_type' => 'roadmap', // roadmap, satellite, hybrid, terrain
            'show_controls' => true,
            'show_poi_labels' => false,
            'custom_styles' => [
                [
                    'featureType' => 'poi',
                    'elementType' => 'labels',
                    'stylers' => [['visibility' => 'off']]
                ]
            ]
        ],

        /*
        |--------------------------------------------------------------------------
        | Marker Settings
        |--------------------------------------------------------------------------
        |
        | Custom marker configuration.
        |
        */
        'marker' => [
            'icon_color' => '#EF4444', // Red color for resort marker
            'size' => 32,
            'title' => 'Resort Location',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resort Information
    |--------------------------------------------------------------------------
    |
    | General resort information displayed alongside the map.
    |
    */
    'resort_info' => [
        'phone' => env('RESORT_PHONE', '+1 (555) 123-4567'),
        'email' => env('RESORT_EMAIL', 'info@paradiseresort.com'),
        'check_in_time' => env('CHECK_IN_TIME', '3:00 PM'),
        'check_out_time' => env('CHECK_OUT_TIME', '11:00 AM'),
        'front_desk_hours' => env('FRONT_DESK_HOURS', '24/7'),
    ],
];
