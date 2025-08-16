<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options to optimize application performance.
    |
    */

    'cache' => [
        /*
        | Default cache TTL for different types of data
        */
        'ttl' => [
            'queries' => env('CACHE_QUERY_TTL', 300), // 5 minutes
            'dashboard' => env('CACHE_DASHBOARD_TTL', 900), // 15 minutes
            'stats' => env('CACHE_STATS_TTL', 600), // 10 minutes
            'static_content' => env('CACHE_STATIC_TTL', 3600), // 1 hour
        ],
    ],

    'database' => [
        /*
        | Enable query optimization features
        */
        'eager_loading' => true,
        'query_caching' => true,
        'connection_pooling' => env('DB_CONNECTION_POOLING', false),
    ],

    'assets' => [
        /*
        | Asset optimization settings
        */
        'minification' => env('ASSET_MINIFICATION', true),
        'compression' => env('ASSET_COMPRESSION', true),
        'versioning' => env('ASSET_VERSIONING', true),
    ],

    'monitoring' => [
        /*
        | Performance monitoring
        */
        'query_logging' => env('QUERY_LOGGING', false),
        'slow_query_threshold' => env('SLOW_QUERY_THRESHOLD', 1000), // milliseconds
    ],
];
