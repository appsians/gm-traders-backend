<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;
class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'User',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Loop through the roles data and update or insert each record
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                $role
            );
        }
    }
}




    // Create roles
  //  $adminRole = Role::firstOrCreate(['name' => 'Admin']);
  //  $userRole = Role::firstOrCreate(['name' => 'user']);

    // Create permissions
   // Permission::firstOrCreate(['name' => 'manage users']);
   // Permission::firstOrCreate(['name' => 'edit articles']);

    // Assign permissions to roles
   // $adminRole->givePermissionTo(['manage users', 'edit articles']);
  //  $userRole->givePermissionTo('edit articles');



