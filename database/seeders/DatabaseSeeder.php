<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            UsersTableSeeder::class,
            ProvincesTableSeeder::class,
            DivisionsTableSeeder::class,
            DistrictsTableSeeder::class,
            TehsilsTableSeeder::class,
            UnionCouncilsTableSeeder::class,
            HouseholdsTableSeeder::class
        ]);
    }
}
