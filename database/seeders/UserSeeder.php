<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Berat',
            'last_name' => 'Niziplioğlu',
            'email' => 'berat@portg.net',
            'password' => Hash::make('1985'),
        ]);
    }
}
