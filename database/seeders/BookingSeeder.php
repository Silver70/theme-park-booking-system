<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'user_id' => 4,
            'room_id' => 1,
            'check_in_date' => '2025-08-15',
            'check_out_date' => '2025-08-22',
            'created_at' => '2025-07-20 10:30:00'
        ]);

        Booking::create([
            'user_id' => 5,
            'room_id' => 4,
            'check_in_date' => '2025-08-10',
            'check_out_date' => '2025-08-17',
            'created_at' => '2025-07-18 14:20:00'
        ]);

        Booking::create([
            'user_id' => 6,
            'room_id' => 2,
            'check_in_date' => '2025-09-05',
            'check_out_date' => '2025-09-12',
            'created_at' => '2025-07-22 09:15:00'
        ]);

        Booking::create([
            'user_id' => 7,
            'room_id' => 5,
            'check_in_date' => '2025-08-25',
            'check_out_date' => '2025-09-01',
            'created_at' => '2025-07-21 16:45:00'
        ]);

        Booking::create([
            'user_id' => 4,
            'room_id' => 7,
            'check_in_date' => '2025-10-10',
            'check_out_date' => '2025-10-15',
            'created_at' => '2025-07-23 11:00:00'
        ]);

        Booking::create([
            'user_id' => 5,
            'room_id' => 3,
            'check_in_date' => '2025-09-20',
            'check_out_date' => '2025-09-25',
            'created_at' => '2025-07-19 13:30:00'
        ]);

        Booking::create([
            'user_id' => 6,
            'room_id' => 6,
            'check_in_date' => '2025-08-30',
            'check_out_date' => '2025-09-06',
            'created_at' => '2025-07-22 08:20:00'
        ]);
    }
}
