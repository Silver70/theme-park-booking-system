<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;

class UpdateExistingBookingsStatusSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Update all existing bookings to have 'confirmed' status
        // This is for migration purposes when adding the booking_status feature
        Booking::whereNull('booking_status')
            ->orWhere('booking_status', '')
            ->update([
                'booking_status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

        $this->command->info('Updated existing bookings to confirmed status.');
    }
}
