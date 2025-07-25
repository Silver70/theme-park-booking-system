<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FerrySchedule;

class FerryScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Today's schedules - Male to Resort routes
        $maleToResortSchedules = [
            ['time' => '06:00:00', 'seats' => 50],
            ['time' => '08:30:00', 'seats' => 45],
            ['time' => '11:00:00', 'seats' => 50],
            ['time' => '14:30:00', 'seats' => 38],
            ['time' => '17:00:00', 'seats' => 50],
            ['time' => '19:30:00', 'seats' => 42]
        ];

        foreach ($maleToResortSchedules as $schedule) {
            FerrySchedule::create([
                'departure_time' => now()->format('Y-m-d') . ' ' . $schedule['time'],
                'origin' => 'Male International Airport',
                'destination' => 'Paradise Resort',
                'seats_available' => $schedule['seats'],
                'created_by' => 2
            ]);
        }

        // Today's schedules - Resort to Male routes
        $resortToMaleSchedules = [
            ['time' => '07:15:00', 'seats' => 50],
            ['time' => '09:45:00', 'seats' => 35],
            ['time' => '12:15:00', 'seats' => 50],
            ['time' => '15:45:00', 'seats' => 28],
            ['time' => '18:15:00', 'seats' => 50],
            ['time' => '20:45:00', 'seats' => 47]
        ];

        foreach ($resortToMaleSchedules as $schedule) {
            FerrySchedule::create([
                'departure_time' => now()->format('Y-m-d') . ' ' . $schedule['time'],
                'origin' => 'Paradise Resort',
                'destination' => 'Male International Airport',
                'seats_available' => $schedule['seats'],
                'created_by' => 2
            ]);
        }

        // Inter-resort routes for today
        FerrySchedule::create([
            'departure_time' => now()->format('Y-m-d') . ' 10:00:00',
            'origin' => 'Paradise Resort',
            'destination' => 'Coral Island Resort',
            'seats_available' => 30,
            'created_by' => 2
        ]);

        FerrySchedule::create([
            'departure_time' => now()->format('Y-m-d') . ' 13:00:00',
            'origin' => 'Coral Island Resort',
            'destination' => 'Paradise Resort',
            'seats_available' => 30,
            'created_by' => 2
        ]);

        FerrySchedule::create([
            'departure_time' => now()->format('Y-m-d') . ' 16:00:00',
            'origin' => 'Paradise Resort',
            'destination' => 'Sunset Beach Resort',
            'seats_available' => 25,
            'created_by' => 2
        ]);

        FerrySchedule::create([
            'departure_time' => now()->format('Y-m-d') . ' 18:30:00',
            'origin' => 'Sunset Beach Resort',
            'destination' => 'Paradise Resort',
            'seats_available' => 25,
            'created_by' => 2
        ]);

        // Tomorrow's schedules - Male to Resort
        foreach ($maleToResortSchedules as $schedule) {
            FerrySchedule::create([
                'departure_time' => now()->addDay()->format('Y-m-d') . ' ' . $schedule['time'],
                'origin' => 'Male International Airport',
                'destination' => 'Paradise Resort',
                'seats_available' => 50,
                'created_by' => 2
            ]);
        }

        // Tomorrow's schedules - Resort to Male
        foreach ($resortToMaleSchedules as $schedule) {
            FerrySchedule::create([
                'departure_time' => now()->addDay()->format('Y-m-d') . ' ' . $schedule['time'],
                'origin' => 'Paradise Resort',
                'destination' => 'Male International Airport',
                'seats_available' => 50,
                'created_by' => 2
            ]);
        }
    }
}
