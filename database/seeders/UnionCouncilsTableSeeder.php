<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tehsil;
use App\Models\UnionCouncil;

class UnionCouncilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Union Councils for Tehsil: Bahawalnagar
        $bahawalnagarUnionCouncils = [
            'Municipal Committee, Bahawalnagar',
            'Town Committee, Ahmedpur Meclodgunj',
            'Municipal Committee, Chistian',
            'Town Committee, Maroot',
            'Municipal Committee, Haroonabad'
        ];

        // Union Councils for Tehsil: Minchanabad
        $minchanabadUnionCouncils = [
            'Laleka'
        ];

        // Union Councils for Tehsil: Kot Chutta
        $KotChuttaUnionCouncils = [
            'Choti Zaireen', 'Jhoke Uttra', 'Basti Malana', 'Jhakkar Imam sharif'
        ];

        // Insert Union Councils for Bahawalnagar
        $bahawalnagarTehsilId = Tehsil::where('name', 'Bahawalnagar')->first()->id;
        foreach ($bahawalnagarUnionCouncils as $unionCouncil) {
            UnionCouncil::create([
                'name' => $unionCouncil,
                'tehsil_id' => $bahawalnagarTehsilId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert Union Councils for Minchanabad
        $minchanabadTehsilId = Tehsil::where('name', 'Minchanabad')->first()->id;
        foreach ($minchanabadUnionCouncils as $unionCouncil) {
            UnionCouncil::create([
                'name' => $unionCouncil,
                'tehsil_id' => $minchanabadTehsilId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert Union Councils for Kot Chutta
        $KotChuttaTehsilId = Tehsil::where('name', 'Kot Chutta')->first()->id;
        foreach ($KotChuttaUnionCouncils as $unionCouncil) {
            UnionCouncil::create([
                'name' => $unionCouncil,
                'tehsil_id' => $KotChuttaTehsilId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
