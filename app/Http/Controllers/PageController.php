<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($_SERVER['REMOTE_ADDR']);
        return view('home');
    }
}
