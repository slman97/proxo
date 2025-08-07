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
        User::firstOrCreate([
            'name' => 'Mohammed',
            'email' => 'mohammed@proxo.com',
            'password' => 'mohammed@123456',
        ]);
        User::firstOrCreate([
            'name' => 'Slman',
            'email' => 'slman@proxo.com',
            'password' => 'slman@123456',
        ]);
    }
}
