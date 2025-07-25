<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Beach Villa Deluxe',
            'description' => 'Luxurious beachfront villa with private pool and stunning ocean views',
            'image' => 'beach_villa_deluxe.jpg',
            'price' => 450.00
        ]);

        Room::create([
            'name' => 'Ocean View Suite',
            'description' => 'Spacious suite with panoramic ocean views and modern amenities',
            'image' => 'ocean_view_suite.jpg',
            'price' => 280.00
        ]);

        Room::create([
            'name' => 'Garden Bungalow',
            'description' => 'Traditional Maldivian bungalow surrounded by tropical gardens',
            'image' => 'garden_bungalow.jpg',
            'price' => 180.00
        ]);

        Room::create([
            'name' => 'Overwater Villa',
            'description' => 'Iconic overwater villa with direct lagoon access',
            'image' => 'overwater_villa.jpg',
            'price' => 650.00
        ]);

        Room::create([
            'name' => 'Family Room',
            'description' => 'Large family room accommodating up to 4 guests',
            'image' => 'family_room.jpg',
            'price' => 320.00
        ]);

        Room::create([
            'name' => 'Standard Room',
            'description' => 'Comfortable standard room with garden view',
            'image' => 'standard_room.jpg',
            'price' => 120.00
        ]);

        Room::create([
            'name' => 'Presidential Suite',
            'description' => 'Ultimate luxury suite with private butler service',
            'image' => 'presidential_suite.jpg',
            'price' => 1200.00
        ]);

        Room::create([
            'name' => 'Sunset Villa',
            'description' => 'Perfect villa for watching breathtaking Maldivian sunsets',
            'image' => 'sunset_villa.jpg',
            'price' => 380.00
        ]);
    }
}
