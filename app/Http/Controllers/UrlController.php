<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function create(Request $request)
    {
        $existent = \App\ShortUrl::where('short', $request->input('short'))->first();

        if(!$existent) {

            $shortUrl = \App\ShortUrl::create([
                'short' => $request->input('short'),
                'long' => $request->input('long')
            ]);
        } else {
            $shortUrl = $existent;
        }

        return view('shorturl', compact('shortUrl'));
    }

    public function redirect(Request $request, $shortUrl)
    {
        $url = \App\ShortUrl::where('short', $shortUrl)->first();

        return redirect($url->long);
    }
}
