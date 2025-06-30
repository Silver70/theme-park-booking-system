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
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        //create hotel owner user
        $hotelOwner = User::create([
            'name' => 'Hotel Owner',
            'email' => 'hotelowner@example.com',
            'password' => Hash::make('password'),
        ]);
        $hotelOwner->assignRole('hotel_owner');

        //create visitor user
        $visitor = User::create([
            'name' => 'Visitor',
            'email' => 'visitor@example.com',
            'password' => Hash::make('password'),
        ]);
        $visitor->assignRole('visitor');

        //create ferry operator user
        $ferryOperator = User::create([
            'name' => 'Ferry Operator',
            'email' => 'ferryoperator@example.com',
            'password' => Hash::make('password'),
        ]);
        $ferryOperator->assignRole('ferry_operator');
    }
}
