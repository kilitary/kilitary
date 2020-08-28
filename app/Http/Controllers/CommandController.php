<?php

namespace App\Http\Controllers;

use App\XRandom;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function rand(Request $request)
    {
        $list['rand'] = XRandom::getAu(10);

        return view('list', compact('list'));
    }
}
