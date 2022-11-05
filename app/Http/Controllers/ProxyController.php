<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;

class ProxyController extends Controller
{
    public function list(Request $request)
    {
        $proxys = Cache::remember('proxys', 120, function () {
            return \App\Proxy::select('host', 'port', 'created_at', 'type', 'anonymity', 'speed', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->orderBy('checked_at', 'DESC')
                ->limit(200)
                ->get();
        });

        $description = 'Список бесплатных прокси, рабочие proxy socks сервера, Экспорт в txt, csv, либо по API.';

        return view('proxy', compact('proxys', 'description'));
    }
}
