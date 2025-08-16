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
            'image' => 'room-images/beach_villa_deluxe.jpg',
            'price' => 450.00
        ]);

        Room::create([
            'name' => 'Ocean View Suite',
            'description' => 'Spacious suite with panoramic ocean views and modern amenities',
            'image' => 'room-images/ocean_view_suite.jpg',
            'price' => 280.00
        ]);

        Room::create([
            'name' => 'Garden Bungalow',
            'description' => 'Traditional Maldivian bungalow surrounded by tropical gardens',
            'image' => 'room-images/garden_bungalow.jpg',
            'price' => 180.00
        ]);

     
    }
}
