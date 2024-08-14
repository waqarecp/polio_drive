<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvincesTableSeeder extends Seeder
{
    public function run()
    {
        $provinces = [
            'Punjab',
            'KPK',
            'Sindh',
            'Balochistan',
            'Azad Jammu Kashmir',
            'Gilgit Baltistan'
        ];

        foreach ($provinces as $province) {
            Province::create(['name' => $province]);
        }
    }
}
