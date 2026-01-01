<?php

namespace Database\Seeders;

use App\Models\Consultancy;
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

          $this->call(RolesPermissionSeeder::class);
           $this->call(ConsultancySeeder::class);
            $this->call(PlantSeeder::class);
             $this->call(AdminUserSeeder::class);
        // User::factory(10)->create();


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
