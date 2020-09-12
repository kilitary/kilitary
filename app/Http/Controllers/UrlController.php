<?php

namespace App\Http\Controllers;

use App\XRandom;
use Illuminate\Http\Request;
use App\Logger;

class UrlController extends Controller
{
    public function create(Request $request)
    {
        if(empty($request->input('short'))) {
            $request['short'] = \Str::random(8);
        }

        if(empty($request->input('long'))) {
            $request['long'] = \Str::random(8);
        }

        $existent = \App\ShortUrl::where('short', $request->input('short'))
            ->first();

        if(!$existent) {
            Logger::msg('creating ' . $request->input('short') . ' => ' . $request->input('long') . ' link' . ' by ' . $request->ip());
            $shortUrl = \App\ShortUrl::create([
                'short' => $request->input('short'),
                'long' => $request->input('long'),
                'visits' => 0,
                'creater_ip' => $request->ip()
            ]);
        } else {
            $shortUrl = $existent;
            Logger::msg($shortUrl->short . ' => ' . $existent->long . ' by ' . $request->ip());
        }

        $success = XRandom::get(0, 1) ? 'true' : 'false';

        return view('shorturl', compact('shortUrl', 'success'));
    }

    public function redirect(Request $request, $shortUrl)
    {
        $shortUrl = \App\ShortUrl::where('short', $shortUrl)
            ->first();
        if($shortUrl) {
            Logger::msg('redirect ' . $shortUrl->short . '=>' . $shortUrl->long . ' by ' . $request->ip());
            $shortUrl->visits += 1;
            $shortUrl->save();
            return redirect($shortUrl->long);
        } else {
            Logger::msg($shortUrl->short . ' => ' . $_SERVER['HTTP_REFERER'] . ' by ' . $request->ip());
            return back();
        }
    }
}
