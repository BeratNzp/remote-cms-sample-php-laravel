<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class CompanyDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::create([
            'title' => 'PortG',
            'company_title' => 'PortG Bilişim',
        ]);
        $department = Department::create([
            'company_id' => $company->id,
            'title' => 'Yönetim',
        ]);
        Department::create([
            'company_id' => $company->id,
            'title' => 'Teknik Destek',
        ]);
        Department::create([
            'company_id' => $company->id,
            'title' => 'Muhasebe',
        ]);

        User::create([
            'department_id' => $department->id,
            'first_name' => 'Berat',
            'last_name' => 'Niziplioğlu',
            'email' => 'berat@portg.net',
            'password' => Hash::make('1985'),
        ]);
    }
}
