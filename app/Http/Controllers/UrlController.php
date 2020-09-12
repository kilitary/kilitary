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

        $existent = \App\ShortUrl::where('shortRecord', $request->input('short'))
            ->first();

        if(!$existent) {
            Logger::msg('creating static ' . $request->input('shortRecord') . ' => ' . $request->input('long') . ' link' . ' by ' . $request->ip());
            $shortUrl = \App\ShortUrl::create([
                'short' => $request->input('short'),
                'long' => $request->input('long'),
                'visits' => 0,
                'creater_ip' => $request->ip()
            ]);
        } else {
            $shortRecord = $existent;
            Logger::msg('redirect ' . $shortRecord->short . ' => ' . $existent->long . ' by ' . $request->ip());
        }

        $success = XRandom::get(0, 1) ? 'true' : 'false';

        return view('shorturl', compact('shortUrl', 'success'));
    }

    public function redirect(Request $request, $shortUrl)
    {
        $shortRecord = \App\ShortUrl::where('short', $shortUrl)
            ->first();
        if($shortRecord) {
            Logger::msg('static redirect ' . $shortRecord->short . '=>' . $shortRecord->long . ' by ' . $request->ip());
            $shortRecord->visits += 1;
            $shortRecord->save();
            return redirect($shortRecord->long);
        } else {
            Logger::msg('redirect ' . $shortUrl . ' => ' . $request->header('referer', 'http://google.com') . ' by ' . $request->ip());
            return back();
        }
    }
}
