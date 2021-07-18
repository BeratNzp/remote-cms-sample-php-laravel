<?php

namespace App\Http\Controllers\RCMS;


class HomeController extends Controller
{
    public function index()
    {
        return view('homepage');
    }
}
