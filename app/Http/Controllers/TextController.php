<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\TextSource;
use App\XRandom;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function identify(Request $request)
    {
        $words = TextSource::all();

        $num = mt_rand(1, 11) * 3;

        for ($i = 0; $i < $num; $i++) {
            $signs = [' ', '+', '-'];
            $sign = $signs[XRandom::get(0, 2)];

            $list[XRandom::sign(5)] = $words[XRandom::get(0, count($words) - 1)] .
                sprintf("%s%02d ", $sign, XRandom::get(0, 9));
        }

        return \response()
            ->view('list-text', compact('list'), \App\XRandom::maybe() ? 417 : 200)
            ->header('Content-Type', 'text/plain');
    }
}
