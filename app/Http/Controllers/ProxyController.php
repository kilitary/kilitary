<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;

class ProxyController extends Controller
{
    public function list(Request $request)
    {
        $proxys = \App\Proxy::select('host', 'port', 'created_at', 'type', 'anonymity', 'speed')
            ->orderBy('checked_at', 'DESC')
            ->limit(100)
            ->get();

        return view('proxy', compact('proxys'));
    }
}
