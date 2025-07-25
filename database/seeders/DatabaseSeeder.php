<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(2)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
            PromotionSeeder::class,
            EventSeeder::class,
            EventTicketSeeder::class,
            FerryScheduleSeeder::class,
            FerryTicketSeeder::class,
        ]);
    }
}
