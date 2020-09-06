<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function redirect(Request $request, $shortUrl)
    {
        $url = \App\ShortUrl::where('short', $shortUrl)->first();

        return redirect($url->long);
    }
}
