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
                'name' => 'Schedules',
                'icon' => 'radix-calendar',
                'route' => 'ferry.schedules',
            ],
            [
                'name' => 'Ticket Validation',
                'icon' => 'radix-badge',
                'route' => 'ferry.tickets.validate',
            ],
            [
                'name' => 'Issue Tickets',
                'icon' => 'radix-bookmark',
                'route' => 'ferry.tickets.create',
            ],
            [
                'name' => 'Passenger List',
                'icon' => 'radix-person',
                'route' => 'ferry.tickets',
            ],
            [
                'name' => 'Reports',
                'icon' => 'radix-bar-chart',
                'route' => 'dashboard',
            ],
        ];
    }
}
