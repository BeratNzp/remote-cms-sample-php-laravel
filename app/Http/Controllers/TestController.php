<?php

namespace App\Http\Controllers;

use App\Models\Department;

class TestController extends Controller
{
    public function index()
    {
        return view('test2');
    }
    public function departments()
    {
        $departments = Department::all();
        return view('test.departments', compact('departments'));
    }


}
