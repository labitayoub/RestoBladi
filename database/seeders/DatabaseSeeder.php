<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            // Vous pouvez ajouter d'autres seeders ici si nécessaire
            // RestaurantSeeder::class,
            // etc.
        ]);
        
        // \App\Models\User::factory(10)->create();
        // \App\Models\Role::factory(10)->create();
        // \App\Models\Manager::factory(10)->create();
        // \App\Models\Waiter::factory(10)->create();
    }
}
