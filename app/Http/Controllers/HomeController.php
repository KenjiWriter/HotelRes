<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        // Tutaj dodamy logikę wyszukiwania później
    }
}