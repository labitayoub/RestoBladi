<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@retobladi.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1, // Admin role
        ]);

        User::create([
            'name' => 'Manager User',
            'email' => 'manager@retobladi.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2, // Manager role
        ]);

        User::create([
            'name' => 'Waiter User',
            'email' => 'waiter@retobladi.com',
            'password' => bcrypt('12345678'),
            'role_id' => 3, // Waiter role
        ]);
    }
}
