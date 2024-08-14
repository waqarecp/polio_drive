<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Province;

class DivisionsTableSeeder extends Seeder
{
    public function run()
    {
        $divisions = [
            'Punjab' => [
                'Bahawalpur',
                'Dera Ghazi Khan',
                'Faisalabad',
                'Gujranwala',
                'Gujrat',
                'Lahore',
                'Mianwali',
                'Multan',
                'Rawalpindi',
                'Sahiwal',
                'Sargodha'
            ],
            'Sindh' => [
                'Hyderabad',
                'Karachi',
                'Larkana',
                'Mirpur Khas',
                'Shaheed Benazirabad',
                'Sukkur'
            ],
            'KPK' => [
                'Bannu',
                'Dera Ismail Khan',
                'Hazara',
                'Kohat',
                'Malakand',
                'Mardan',
                'Peshawar'
            ],
            'Balochistan' => [
                'Kalat',
                'Loralai',
                'Makran',
                'Naseerabad',
                'Quetta',
                'Rakhshan',
                'Sibi',
                'Zhob'
            ],
            'Azad Jammu Kashmir' => [
                'Mirpur',
                'Muzaffarabad',
                'Poonch'
            ],
            'Gilgit Baltistan' => [
                'Gilgit',
                'Baltistan',
                'Diamer'
            ]
        ];

        foreach ($divisions as $provinceName => $divisionList) {
            $province = Province::where('name', $provinceName)->first();

            foreach ($divisionList as $division) {
                Division::create([
                    'name' => $division,
                    'province_id' => $province->id
                ]);
            }
        }
    }
}
