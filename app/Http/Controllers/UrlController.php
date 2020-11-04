<?php

namespace App\Http\Controllers;

use App\Models\Page;
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

        $shortRecord = \App\ShortUrl::where('short', $request->input('short'))
            ->first();

        if(!$shortRecord) {
            Logger::msg('creating static ' . $request->input('short') . ' => ' . $request->input('long') . ' link' . ' by ' . $request->ip());

            $long = $request->input('long');
            if(!strstr($long, "://")) {
                $long = 'http://' . $long;
            }

            $shortUrl = \App\ShortUrl::create([
                'short' => $request->input('short'),
                'long' => $long,
                'visits' => 0,
                'creater_ip' => $request->ip()
            ]);
        } else {
            Logger::msg('redirect ' . $shortRecord->short . ' => ' . $shortRecord->long . ' by ' . $request->ip());
            $shortUrl = new Page();
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
        }

        Logger::msg('redirect ' . $shortUrl . ' => ' . $request->header('referer', 'http://google.com') . ' by ' . $request->ip());
        return back();
    }
}
