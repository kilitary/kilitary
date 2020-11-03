<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;

class ProxyController extends Controller
{
    public function list(Request $request)
    {
        $proxys = \App\Proxy::select('host', 'port', 'created_at', 'type', 'anonymity', 'speed', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->orderBy('checked_at', 'DESC')
            ->limit(100)
            ->get();

        $description = 'Список бесплатных прокси, рабочие proxy socks сервера, Экспорт в txt, csv, либо по API.';

        return view('proxy', compact('proxys', 'description'));
    }
}
