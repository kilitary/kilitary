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
            $list[$algo] = hash($algo, $list['rand']);
        }

        $list['check'] = XRandom::get(0, 1) ? '<font color=green>pass</font>' : '<font color=red>fail</font>';

        return view('list', compact('list'));
    }
}
