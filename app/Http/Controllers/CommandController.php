<?php

namespace App\Http\Controllers;

use App\XRandom;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function sync(Request $request)
    {
//        sscanf(XRandom::getAu(26), "%d", $val);
//        $out = sprintf("%x", $val);
        $list['rand'] = XRandom::getAu(26);
        $list['hashes'] = join(',', hash_algos());

        foreach(hash_algos() as $algo) {
            $hash = hash($algo, $list['rand']);
            $list[$algo] = $hash . " <a target=_blank href='http://google.com/search?q=%2B" . substr($hash, 0, 7) . "'>??</a>";
        }

        $pass = [
            '<font color=green class="blinking-green">pass</font>',
            '<font color=red class="blinking-red">fail</font>',
            '<font color=orange class="blinking-orange">middleware</font>'
        ];
        $list['check'] = $pass[XRandom::get(0, 2)];

        return view('list', compact('list'));
    }
}
