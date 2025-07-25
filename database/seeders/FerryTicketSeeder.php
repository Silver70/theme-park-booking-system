<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FerryTicket;

class FerryTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        FerryTicket::create([
            'user_id' => 4,
            'booking_id' => 1,
            'ferry_schedule_id' => 4, // John's arrival for Beach Villa booking
            'price' => 35.00,
            'created_at' => '2025-07-20 10:45:00'
        ]);

        FerryTicket::create([
            'user_id' => 5,
            'booking_id' => 2,
            'ferry_schedule_id' => 2, // Sarah's arrival for Overwater Villa
            'price' => 35.00,
            'created_at' => '2025-07-18 14:30:00'
        ]);

        FerryTicket::create([
            'user_id' => 6,
            'booking_id' => 3,
            'ferry_schedule_id' => 6, // Ahmed's arrival for Ocean View Suite
            'price' => 35.00,
            'created_at' => '2025-07-22 09:30:00'
        ]);

        FerryTicket::create([
            'user_id' => 7,
            'booking_id' => 4,
            'ferry_schedule_id' => 1, // Maria's arrival for Family Room
            'price' => 35.00,
            'created_at' => '2025-07-21 17:00:00'
        ]);

        FerryTicket::create([
            'user_id' => 4,
            'booking_id' => 1,
            'ferry_schedule_id' => 10, // John's departure
            'price' => 35.00,
            'created_at' => '2025-07-20 10:50:00'
        ]);

        FerryTicket::create([
            'user_id' => 5,
            'booking_id' => 2,
            'ferry_schedule_id' => 12, // Sarah's departure
            'price' => 35.00,
            'created_at' => '2025-07-18 14:35:00'
        ]);

        FerryTicket::create([
            'user_id' => 6,
            'booking_id' => 3,
            'ferry_schedule_id' => 13, // Ahmed's transfer to Coral Island
            'price' => 25.00,
            'created_at' => '2025-07-22 09:45:00'
        ]);

        FerryTicket::create([
            'user_id' => 7,
            'booking_id' => 4,
            'ferry_schedule_id' => 15, // Maria's transfer to Sunset Beach
            'price' => 22.00,
            'created_at' => '2025-07-21 17:10:00'
        ]);
    }
}
