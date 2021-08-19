<?php

namespace Database\Seeders;

use App\Models\Database;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\RCMS\Company;
use App\Models\RCMS\Department;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\Cloner\Data;

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
        Database::create([
            'company_id' => $company->id,
            'ipv4' => '93.89.225.104',
            'port' => '3306',
            'username' => 'tkeportg_portg_panel_user',
            'password' => 'GjE*5H&zut9_',
            'database' => 'tkeportg_laravel',
        ]);
        Database::create([
            'company_id' => $company->id,
            'ipv4' => '127.0.0.1',
            'port' => '3306',
            'username' => 'root',
            'password' => '',
            'database' => 'portg_client_1',
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
            'current_company_id' => $company->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'first_name' => 'Berat',
            'last_name' => 'Niziplioğlu',
            'email' => 'berat@portg.net',
            'password' => Hash::make('1985'),
        ]);


        $company = Company::create([
            'title' => 'X',
            'company_title' => 'X Firması',
        ]);
        $department = Department::create([
            'company_id' => $company->id,
            'title' => 'Y',
        ]);
        Department::create([
            'company_id' => $company->id,
            'title' => 'Z',
        ]);
        Department::create([
            'company_id' => $company->id,
            'title' => 'T',
        ]);

        User::create([
            'current_company_id' => $company->id,
            'company_id' => $company->id,
            'department_id' => $department->id,
            'first_name' => 'Ali',
            'last_name' => 'Kutay',
            'email' => 'ali@x.net',
            'password' => Hash::make('1985'),
        ]);
    }
}
