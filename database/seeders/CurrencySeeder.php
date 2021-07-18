<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RCMS\Currency;


class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'title' => 'USD',
        ]);
        Currency::create([
            'title' => 'TL',
        ]);
    }
}
