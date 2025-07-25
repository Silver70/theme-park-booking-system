<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Event::create([
            'name' => 'Sunset Dolphin Cruise',
            'description' => 'Watch dolphins play in their natural habitat during golden hour',
            'type' => 'ride',
            'location' => 'North Atoll Lagoon',
           
        ]);

        Event::create([
            'name' => 'Cultural Dance Show',
            'description' => 'Traditional Maldivian Boduberu performance with local artists',
            'type' => 'show',
            'location' => 'Resort Main Hall',
           
        ]);

        Event::create([
            'name' => 'Beach Volleyball Tournament',
            'description' => 'Friendly competition on our pristine white sand beach',
            'type' => 'beach_event',
            'location' => 'Main Beach',
           
        ]);

        Event::create([
            'name' => 'Snorkeling Adventure',
            'description' => 'Explore vibrant coral reefs and marine life',
            'type' => 'ride',
            'location' => 'House Reef',
           
        ]);

        Event::create([
            'name' => 'Maldivian Night Market',
            'description' => 'Experience local cuisine and crafts',
            'type' => 'beach_event',
            'location' => 'Beach Pavilion',
           
        ]);

        Event::create([
            'name' => 'Seaplane Scenic Tour',
            'description' => 'Aerial views of atolls and crystal clear waters',
            'type' => 'ride',
            'location' => 'Seaplane Terminal',
           
        ]);

        Event::create([
            'name' => 'Fire Dance Performance',
            'description' => 'Mesmerizing fire dance under the stars',
            'type' => 'show',
            'location' => 'Sunset Deck',
           
        ]);
    }
}
