<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the first user (Admin)
        $admin = User::create([
            'name' => 'Mr Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('12345678'),
            'is_polio_worker' => 0, // Admin should not be a polio worker
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create Admin role and assign all permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $adminRole->syncPermissions($permissions);
        $admin->assignRole($adminRole);

        // Create the second role with specific permissions
        $workerRole = Role::create(['name' => 'Polio Worker']);

        $permissions = [
            'household_access',
            'household_create',
            'household_edit',
            'household_delete',
            'household_member_access',
            'household_member_create',
            'household_member_edit',
            'household_member_delete',
        ];

        $permissions = Permission::whereIn('name', $permissions)->pluck('id')->all();
        $workerRole->syncPermissions($permissions);

        // Create a new user as Polio Worker role and assign necessary permissions
        $workerUsers = [
            [
                'name' => 'Danish Khan',
                'email' => 'worker@demo.com',
                'password' => Hash::make('12345678'),
                'is_polio_worker' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ali Ahmad',
                'email' => 'ahmad@demo.com',
                'password' => Hash::make('12345678'),
                'is_polio_worker' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Muhammad Jamal',
                'email' => 'jamal@demo.com',
                'password' => Hash::make('12345678'),
                'is_polio_worker' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($workerUsers as $worker) {
            $workerUser = User::create($worker);
            $workerUser->assignRole($workerRole);
        }
    }
}
