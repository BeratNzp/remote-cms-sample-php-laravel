<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RCMS\Country;
use App\Models\RCMS\City;
use App\Models\RCMS\County;

class CountryCityCountySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::create([
            'title' => 'Turkey',
        ]);
        $city = City::create([
            'country_id' => $country->id,
            'title' => 'İstanbul',
        ]);
        County::create([
            'city_id' => $city->id,
            'title' => 'Beşiktaş',
        ]);
    }
}
