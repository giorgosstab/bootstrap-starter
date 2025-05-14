<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index(): string
    {
        return view('home');
    }
}