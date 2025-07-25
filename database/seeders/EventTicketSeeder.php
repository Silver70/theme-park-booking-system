<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventTicket;

class EventTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        EventTicket::create([
            'user_id' => 4,
            'event_id' => 1,
            'price' => 85.00,
            'created_at' => '2025-07-20 11:00:00'
        ]);

        EventTicket::create([
            'user_id' => 4,
            'event_id' => 2,
            'price' => 45.00,
            'created_at' => '2025-07-20 11:05:00'
        ]);

        EventTicket::create([
            'user_id' => 5,
            'event_id' => 3,
            'price' => 25.00,
            'created_at' => '2025-07-18 15:00:00'
        ]);

        EventTicket::create([
            'user_id' => 5,
            'event_id' => 4,
            'price' => 95.00,
            'created_at' => '2025-07-18 15:10:00'
        ]);

        EventTicket::create([
            'user_id' => 6,
            'event_id' => 1,
            'price' => 85.00,
            'created_at' => '2025-07-22 10:00:00'
        ]);

        EventTicket::create([
            'user_id' => 6,
            'event_id' => 6,
            'price' => 250.00,
            'created_at' => '2025-07-22 10:30:00'
        ]);

        EventTicket::create([
            'user_id' => 7,
            'event_id' => 2,
            'price' => 45.00,
            'created_at' => '2025-07-21 17:00:00'
        ]);

        EventTicket::create([
            'user_id' => 7,
            'event_id' => 5,
            'price' => 35.00,
            'created_at' => '2025-07-21 17:05:00'
        ]);
    }
}
