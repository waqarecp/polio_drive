<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnionCouncil;
use App\Models\Household;
use App\Models\HouseholdMember;
use Faker\Factory as Faker;

class HouseholdsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all Union Councils
        $unionCouncils = UnionCouncil::all();

        foreach ($unionCouncils as $unionCouncil) {
            // Create 3 Households for each Union Council
            for ($i = 0; $i < 3; $i++) {
                $household = Household::create([
                    'union_council_id' => $unionCouncil->id,
                    'household_name' => $faker->lastName . ' Family',
                ]);

                // Create 10 Household Members for each Household
                for ($j = 0; $j < 10; $j++) {
                    HouseholdMember::create([
                        'household_id' => $household->id,
                        'member_name' => $faker->firstName,
                        'age' => $faker->numberBetween(1, 80),
                        'gender' => $faker->randomElement(['Male', 'Female']),
                        'vaccinated' => $faker->boolean(50), // Randomly set to true or false
                    ]);
                }
            }
        }
    }
}
