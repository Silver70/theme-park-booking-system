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
                'icon' => 'dashboard',
                'route' => 'dashboard',
            ],
            [
                'name' => 'Attractions',
                'icon' => 'rooms',
                // 'children' => [
                //     ['name' => 'View All', 'route' => 'dashboard'],
                //     ['name' => 'Add All', 'route' => 'dashboard'],
                // ]
                'route' => 'dashboard',
            ],
            
            [
                'name' => 'Analytics',
                'icon' => 'chart',
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
                'icon' => 'calendar',
                'route' => 'ferry.schedules',
            ],
            [
                'name' => 'Ticket Validation',
                'icon' => 'chart',
                'route' => 'ferry.tickets.validate',
            ],
            [
                'name' => 'Issue Tickets',
                'icon' => 'chart',
                'route' => 'ferry.tickets.create',
            ],
            [
                'name' => 'Passenger List',
                'icon' => 'users',
                'route' => 'ferry.tickets',
            ],
            [
                'name' => 'Reports',
                'icon' => 'chart',
                'route' => 'dashboard',
            ],
        ];
    }

    /**
     * Get admin dashboard menu items
     *
     * @return array
     */
    public function getAdminMenu(): array
    {
        return [
            [
                'name' => 'Dashboard',
                'icon' => 'dashboard',
                'route' => 'admin.dashboard',
            ],
            [
                'name' => 'User Management',
                'icon' => 'users',
                'route' => 'admin.users.index',
            ],
            [
                'name' => 'Hotel Management',
                'icon' => 'rooms',
                'children' => [
                    ['name' => 'All Rooms', 'route' => 'admin.rooms.index'],
                    ['name' => 'Bookings', 'route' => 'admin.bookings.index'],
                ]
            ],
            [
                'name' => 'Ferry Management',
                'icon' => 'calendar',
                'children' => [
                    ['name' => 'Schedules', 'route' => 'admin.ferry.schedules'],
                    ['name' => 'Tickets', 'route' => 'admin.ferry.tickets'],
                ]
            ],
            [
                'name' => 'Content Management',
                'icon' => 'image',
                'children' => [
                    ['name' => 'Dashboard Images', 'route' => 'admin.dashboard-images.index'],
                    ['name' => 'Locations', 'route' => 'admin.locations.index'],
                ]
            ],
            [
                'name' => 'Reports',
                'icon' => 'chart',
                'route' => 'admin.reports.index',
            ],
            [
                'name' => 'Analytics',
                'icon' => 'chart',
                'route' => 'admin.reports.analytics',
            ],
        ];
    }

    public function getHotelStaffMenu(): array
    {
        return [
            [
                'name' => 'Dashboard',
                'icon' => 'dashboard',
                'route' => 'hotelstaff.dashboard',
            ],
            [
                'name' => 'Rooms',
                'icon' => 'rooms',
                'route' => 'hotelstaff.rooms.index',
            ],
            [
                'name' => 'Bookings',
                'icon' => 'calendar',
                'route' => 'hotelstaff.bookings.index',
            ],
            [
                'name' => 'Promotions',
                'icon' => 'chart',
                'route' => 'hotelstaff.promotions.index',
            ],
            [
                'name' => 'Reports',
                'icon' => 'chart',
                'route' => 'hotelstaff.reports.index',
            ],
        ];
    }

    /**
     * Get visitor dashboard menu items
     *
     * @return array
     */
    public function getVisitorMenu(): array
    {
        return [
            [
                'name' => 'Overview',
                'icon' => 'dashboard',
                'route' => 'welcome',
            ],
            [
                'name' => 'Accommodations',
                'icon' => 'rooms',
                'route' => 'rooms.index',
            ],
            [
                'name' => 'Ferry Schedules',
                'icon' => 'calendar',
                'route' => 'schedules.index',
            ],
            [
                'name' => 'Explore Map',
                'icon' => 'chart',
                'route' => 'explore-map.index',
            ],
            [
                'name' => 'Attractions',
                'icon' => 'image',
                'route' => 'welcome',
            ],
        ];
    }
}
