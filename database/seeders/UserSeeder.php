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
            'name' => 'Ayoub',
            'email' => 'admin@restobladi.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1, // Admin role
        ]);

    }
}
