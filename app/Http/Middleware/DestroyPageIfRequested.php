<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Redis;

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
            \App\Logger::msg('facing destroyed page for ' . $request->ip());
            ini_set('pcre.backtrack_limit', 100000000);
            ini_set('pcre.recursion_limit', 1000000);

            $content = $response->getContent();
            $numMatches = preg_match_all("#class=['\"]*?([^'\"><\s]{1,120}?)['\"]*?#Usmi", $content, $matches, \PREG_SET_ORDER);

            if($numMatches) {
                $classes = collect([]);
                foreach($matches as $match) {
                    if(!$classes->contains($match[1])) {
                        $classes->add($match[1]);
                    }
                }

                foreach($classes->toArray() as $class) {
                    \App\XRandom::followRand(\App\XRandom::scaled(2, 5));

                    $replaces = 0;
                    $maxClasses = $classes->count() ? $classes->count() - 1 : 0;
                    if($maxClasses) {
                        $newClass = $classes->offsetGet(\App\XRandom::scaled(0, $maxClasses));

                        $content = str_replace(
                            $class,
                            $newClass,
                            $content,
                            $replaces);

                        if(config('site.internal_debug') == true) {
                            \App\Logger::msg('class ' . $class . '->' . $newClass . ': ' . $replaces . ' replaces');
                        }
                    } else if(config('site.internal_debug') == true) {
                        \App\Logger::msg('error: no classes!');
                    }
                }

                $response->setContent($content);
            }
        }

        return $response;
    }
}
