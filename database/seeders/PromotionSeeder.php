<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Promotion::create([
            'title' => 'Early Bird Special',
            'description' => 'Book 60 days in advance and save 25% on your stay',
            'image' => 'early_bird_promo.jpg',
            'valid_until' => '2025-12-31',
            'created_by' => 1
        ]);

        Promotion::create([
            'title' => 'Ferry + Accommodation Package',
            'description' => 'Special discounted ferry rates when booking 5+ nights',
            'image' => 'ferry_package_promo.jpg',
            'valid_until' => '2025-10-31',
            'created_by' => 2
        ]);

        Promotion::create([
            'title' => 'Honeymoon Paradise',
            'description' => 'Romantic getaway package with complimentary sunset cruise',
            'image' => 'honeymoon_promo.jpg',
            'valid_until' => '2025-09-30',
            'created_by' => 1
        ]);

        Promotion::create([
            'title' => 'Family Fun Week',
            'description' => 'Kids stay free promotion with free ferry transfers',
            'image' => 'family_promo.jpg',
            'valid_until' => '2025-08-31',
            'created_by' => 8
        ]);

        Promotion::create([
            'title' => 'Monsoon Season Deal',
            'description' => 'Special rates during monsoon season with free activities',
            'image' => 'monsoon_promo.jpg',
            'valid_until' => '2025-11-30',
            'created_by' => 1
        ]);
    }
}
