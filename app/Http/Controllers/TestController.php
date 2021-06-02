<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function companies()
    {
        $companies = Company::all();
        return view('test.companies', compact('companies'));
    }
    public function departments()
    {
        $departments = Department::all();
        return view('test.departments', compact('departments'));
    }


}
