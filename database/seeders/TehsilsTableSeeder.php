<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\Tehsil;

class TehsilsTableSeeder extends Seeder
{
    public function run()
    {
        // Tehsils for District: Bahawalnagar (Province: Punjab)
        $bahawalnagarTehsils = [
            'Bahawalnagar',
            'Minchanabad',
            'Chishtian',
            'Haroonabad',
            'Fort Abbas'
        ];

        // Tehsils for District: Bahawalpur (Province: Punjab)
        $bahawalpurTehsils = [
            'Bahawalpur City',
            'Ahmedpur Sharqia',
            'Hasilpur',
            'Khairpur',
            'Tamewali',
            'Yazman',
            'Bahawalpur Saddar'
        ];

        // Tehsils for District: Dera Ghazi Khan (Province: Punjab)
        $deraGhaziKhanTehsils = [
            'Dera Ghazi Khan',
            'Kot Chutta',
            'Koh-e-sulaiman'
        ];

        // Insert Tehsils for Bahawalnagar
        $bahawalnagarDistrictId = District::where('name', 'Bahawalnagar')->first()->id;
        foreach ($bahawalnagarTehsils as $tehsil) {
            Tehsil::create([
                'name' => $tehsil,
                'district_id' => $bahawalnagarDistrictId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert Tehsils for Bahawalpur
        $bahawalpurDistrictId = District::where('name', 'Bahawalpur')->first()->id;
        foreach ($bahawalpurTehsils as $tehsil) {
            Tehsil::create([
                'name' => $tehsil,
                'district_id' => $bahawalpurDistrictId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert Tehsils for Dera Ghazi Khan
        $deraGhaziKhanDistrictId = District::where('name', 'Dera Ghazi Khan')->first()->id;
        foreach ($deraGhaziKhanTehsils as $tehsil) {
            Tehsil::create([
                'name' => $tehsil,
                'district_id' => $deraGhaziKhanDistrictId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
