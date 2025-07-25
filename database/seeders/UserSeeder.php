<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create admin user
        User::create([
            'name' => 'admin',
            'email' => 'admin@resort.com',
            'password' => Hash::make('password123'),
        ])->assignRole('admin');

        User::create([
            'name' => 'ferry_operator_1',
            'email' => 'ferry1@resort.com',
            'password' => Hash::make('password123'),
        ])->assignRole('ferry_operator');

        User::create([
            'name' => 'ferry_operator_2',
            'email' => 'ferry2@resort.com',
            'password' => Hash::make('password123'),
        ])->assignRole('ferry_operator');

        User::create([
            'name' => 'guest_john',
            'email' => 'john.doe@email.com',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::create([
            'name' => 'guest_sarah',
            'email' => 'sarah.smith@email.com',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::create([
            'name' => 'guest_ahmed',
            'email' => 'ahmed.hassan@email.com',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::create([
            'name' => 'guest_maria',
            'email' => 'maria.garcia@email.com',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::create([
            'name' => 'hotel_owner_1',
            'email' => 'hotel1@resort.com',
            'password' => Hash::make('password123'),
        ])->assignRole('hotel_owner');

    
    }
}
