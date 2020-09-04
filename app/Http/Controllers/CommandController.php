<?php

namespace App\Http\Controllers;

use App\XRandom;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function sync(Request $request)
    {
        $list['rand'] = \strtoupper(XRandom::sign(26));//::getAu(26);

        foreach(hash_algos() as $algo) {
            $hash = hash($algo, $list['rand']);
            $list[$algo] = $hash . " <a target=_blank href='https://google.com/search?q=%2B" . substr($hash, 0, 7) . "'>[?]</a>" .
                " <a target=_blank href='https://google.com/search?q=related:" . substr($hash, 0, 6) . "'>[I]</a>" .
                " <a target=_blank href='https://google.com/search?q=inurl:" . substr($hash, 0, 7) . "'>[L]</a>" .
                " <a target=_blank href='https://google.com/search?q=" . substr($hash, 0, 6) . "'>[E]</a>".
                " <a target=_blank href='https://google.com/search?q=site:github.com%20" . substr($hash, 0, 6) . "'>[C]</a>";

        }

        $pass = [
            '<font color=green class="blinking-green">pass</font>',
            '<font color=red class="blinking-red">fail</font>',
            '<font color=orange class="blinking-orange">middleware</font>'
        ];
        $list['check'] = $pass[XRandom::get(0, 2)];

        return view('list', compact('list'));
    }

    public function play(Request $request)
    {
        $val = XRandom::getAu(26);
        $list['val'] = $val;

        return view('list', compact('list'));
    }
}

