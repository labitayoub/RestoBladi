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
        
        User::insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@restobladi.com',
                'password' => bcrypt('password1234'),
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'waiter',
                'email' =>'waiter@restobladi.com',
                'password' => bcrypt('password1234'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],  
        ]);
    }
}
