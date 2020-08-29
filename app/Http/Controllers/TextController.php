<?php

namespace App\Http\Controllers;

use App\XRandom;
use Filicious\Local\LocalAdapter;
use Filicious\Filesystem;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function identify(Request $request)
    {
        $words = file("../american-english-huge");

        $num = mt_rand(0, 26) * 9;
        for($i = 0; $i < $num; $i++) {
            $list[XRandom::sign(5)] = $words[XRandom::get(0, count($words) - 1)];
        }

        return view('list-text', compact('list'));
    }
}
