<?php
// app/Services/MenuService.php

namespace App\Services;

class MenuService
{
    /**
     * Get admin dashboard menu items
     *
     * @return array
     */
    public function getHotelMenu(): array
    {
        return [
            [
                'name' => 'Dashboard',
                'icon' => 'radix-dashboard',
                'route' => 'dashboard',
            ],
            [
                'name' => 'Attractions',
                'icon' => 'fluentui-conference-room-20-o',
                // 'children' => [
                //     ['name' => 'View All', 'route' => 'dashboard'],
                //     ['name' => 'Add New', 'route' => 'dashboard'],
                // ]
                'route' => 'dashboard',
            ],
            
            [
                'name' => 'Analytics',
                'icon' => 'carbon-analytics',
                'route' => 'dashboard',
            ],
        ];
    }

    /**
     * Get staff dashboard menu items
     *
     * @return array
     */
    public function getFerryOperatorMenu(): array
    {
        return [
            [
                'name' => 'Dashboard',
                'icon' => 'radix-dashboard',
                'route' => 'ferry.dashboard',
            ],
            [
                'name' => 'Ferries',
                'icon' => 'radix-rocket',
                'route' => 'ferry.schedules.create',
            ],
            [
                'name' => 'Schedules',
                'icon' => 'radix-calendar',
                'route' => 'ferry.schedules',
            ],
            [
                'name' => 'Routes',
                'icon' => 'radix-target',
                'route' => 'dashboard',
            ],
            [
                'name' => 'Bookings',
                'icon' => 'radix-bookmark',
                'route' => 'dashboard',
            ],
            [
                'name' => 'Announcements',
                'icon' => 'radix-chat-bubble',
                'route' => 'dashboard',
            ],
            [
                'name' => 'Reports',
                'icon' => 'radix-bar-chart',
                'route' => 'dashboard',
            ],
        ];
    }
}
