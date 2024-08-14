<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\District;
use App\Models\Division;

class DistrictsTableSeeder extends Seeder
{
    public function run()
    {
        $districts = [
            'Bahawalpur' => ['Bahawalnagar', 'Bahawalpur', 'Rahim Yar Khan'],
            'Dera Ghazi Khan' => ['Dera Ghazi Khan', 'Jampur', 'Layyah', 'Muzaffargarh', 'Rajanpur', 'Taunsa', 'Kot Addu'],
            'Hyderabad' => ['Badin', 'Dadu', 'Ghotki', 'Hyderabad'],
            'Karachi' => ['Karachi Central', 'Karachi East', 'Karachi South', 'Karachi West'],
            'Bannu' => ['Bannu', 'Lakki Marwat', 'North Waziristan'],
            'Dera Ismail Khan' => ['Dera Ismail Khan', 'Upper South Waziristan', 'Tank'],
            'Kalat' => ['Awaran', 'Kalat', 'Hub', 'Lasbela'],
            'Loralai' => ['Barkhan', 'Duki', 'Loralai', 'Musakhel'],
            'Mirpur' => ['Mirpur', 'Bhimber', 'Kotli'],
            'Muzaffarabad' => ['Muzaffarabad', 'Hattian Bala', 'Neelum'],
            'Gilgit' => ['Ghizer', 'Gilgit', 'Hunza'],
            'Baltistan' => ['Kharmang', 'Shigar', 'Ghanche'],
        ];

        foreach ($districts as $divisionName => $districtList) {
            $division = Division::where('name', $divisionName)->first();

            foreach ($districtList as $district) {
                District::create([
                    'name' => $district,
                    'division_id' => $division->id
                ]);
            }
        }
    }
}
