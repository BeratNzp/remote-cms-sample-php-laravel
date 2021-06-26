<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('welcome');
    }
    public function test_index()
    {
        $companies = Company::all();
        return view('test.companies', compact('companies'));
    }
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
