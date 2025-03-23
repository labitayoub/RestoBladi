<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Role::factory()->create([
            [
                'id' => 1,
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'waiter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Vous pouvez ajouter d'autres rôles selon vos besoins
        ]);
    }
}
