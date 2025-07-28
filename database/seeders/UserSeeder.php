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
        User::firstOrCreate([
            'email' => 'admin@resort.com',
        ], [
            'name' => 'admin',
            'password' => Hash::make('password123'),
        ])->assignRole('admin');

        User::firstOrCreate([
            'email' => 'ferry1@resort.com',
        ], [
            'name' => 'ferry_operator_1',
            'password' => Hash::make('password123'),
        ])->assignRole('ferry_operator');

        User::firstOrCreate([
            'email' => 'ferry2@resort.com',
        ], [
            'name' => 'ferry_operator_2',
            'password' => Hash::make('password123'),
        ])->assignRole('ferry_operator');

        User::firstOrCreate([
            'email' => 'john.doe@email.com',
        ], [
            'name' => 'guest_john',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::firstOrCreate([
            'email' => 'sarah.smith@email.com',
        ], [
            'name' => 'guest_sarah',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::firstOrCreate([
            'email' => 'ahmed.hassan@email.com',
        ], [
            'name' => 'guest_ahmed',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::firstOrCreate([
            'email' => 'maria.garcia@email.com',
        ], [
            'name' => 'guest_maria',
            'password' => Hash::make('password123'),
        ])->assignRole('visitor');

        User::firstOrCreate([
            'email' => 'hotel1@resort.com',
        ], [
            'name' => 'hotel_owner_1',
            'password' => Hash::make('password123'),
        ])->assignRole('hotel_owner');

        User::firstOrCreate([
            'email' => 'staff1@resort.com',
        ], [
            'name' => 'hotel_staff_1',
            'password' => Hash::make('password123'),
        ])->assignRole('hotel_staff');

        User::firstOrCreate([
            'email' => 'staff2@resort.com',
        ], [
            'name' => 'hotel_staff_2',
            'password' => Hash::make('password123'),
        ])->assignRole('hotel_staff');

        User::firstOrCreate([
            'email' => 'staff3@resort.com',
        ], [
            'name' => 'hotel_staff_3',
            'password' => Hash::make('password123'),
        ])->assignRole('hotel_staff');
    }
}
