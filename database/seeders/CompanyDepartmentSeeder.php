<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Department;

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
        Department::create([
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
    }
}
