<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;

class DestroyPageIfRequested
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $destroy = Redis::get($request->ip() . ':destroy', false);
        if($destroy) {
            ini_set('pcre.backtrack_limit', 100000000);
            ini_set('pcre.recursion_limit', 1000000);

            $content = $response->getContent();

            preg_match_all("#class=['\"]*?([^'\"><\s]{1,120}?)['\"]*?#Usmi", $content, $matches, \PREG_SET_ORDER);

            $classes = collect([]);
            foreach($matches as $match) {
                if(!$classes->contains($match[1])) {
                    $classes->add($match[1]);
                }
            }

            $done = 0;
            foreach($classes->toArray() as $class) {
                $content = str_replace(
                    $classes->random(1)->toArray()[0],
                    $classes->random(1)->toArray()[0],
                    $content,
                    $done);
            }

            $response->setContent($content);
        }

        return $response;
    }
}
