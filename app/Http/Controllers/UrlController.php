<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $existent = \App\ShortUrl::where('short', $request->input('short'))->first();

        if(!$existent) {

            $shortUrl = \App\ShortUrl::create([
                'short' => $request->input('short'),
                'long' => $request->input('long'),
                'visits' => 0
            ]);
        } else {
            $shortUrl = $existent;
        }

        return view('shorturl', compact('shortUrl'));
    }

    public function redirect(Request $request, $shortUrl)
    {
        $url = \App\ShortUrl::where('short', $shortUrl)->first();
        $url->visits += 1;
        $url->save();

        return redirect($url->long);
    }
}
