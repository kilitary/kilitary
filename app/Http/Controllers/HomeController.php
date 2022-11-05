<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('site');
    }

    public function check(Request $request)
    {
        if ($request->has('a')) {
            dd(session()->all());
        }
        return redirect('/')->with('message', 'check OK');
    }
}
