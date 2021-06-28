<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountryCityCountySeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(CompanyDepartmentSeeder::class);
        //$this->call(UserSeeder::class);
    }
}
