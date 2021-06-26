<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;
use App\Models\County;

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
