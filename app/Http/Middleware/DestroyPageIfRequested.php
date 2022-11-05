<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Redis;
use \App\Logger;
use \App\XRandom;

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

        $destroy = \Tools::getUserValue('destroy', false);
        if ($destroy) {
            Logger::msg('facing destroyed page for ' . $request->ip());
            ini_set('pcre.backtrack_limit', 1009);
            ini_set('pcre.recursion_limit', 100);

            $content = $response->getContent();
            $numMatches = preg_match_all("#class=['\"]*?([^'\"><\s]{1,120}?)['\"]*?#Usmi", $content, $matches, \PREG_SET_ORDER);

            if ($numMatches) {
                $classes = collect([]);
                foreach ($matches as $match) {
                    if (!$classes->contains($match[1])) {
                        $classes->add($match[1]);
                    }
                }

                foreach ($classes->toArray() as $class) {
                    XRandom::followRand(\App\XRandom::scaled(2, 15));

                    $replaces = 0;
                    $maxClasses = $classes->count() ? $classes->count() - 1 : 0;
                    if ($maxClasses) {
                        $newClass = $classes->offsetGet(\App\XRandom::scaled(0, $maxClasses));

                        $content = str_replace(
                            $class,
                            $newClass,
                            $content,
                            $replaces);

                        if (config('site.internal_debug')) {
                            Logger::msg('class ' . $class . '->' . $newClass . ': ' . $replaces . ' replaces');
                        }
                    } elseif (config('site.internal_debug')) {
                        Logger::msg('error: no classes!');
                    }
                }

                if (XRandom::get(0, 4) == 3) {
                    $content = 'destroying sir!' . $content;
                }
                $response->setContent($content);
            }
        }

        $terminate = \Tools::getUserValue('terminate_fatal_sign');
        if ($terminate) {
            $content = '500: server error';
            $response->setStatusCode(500, 'server error');
            $response->setContent($content);
        }

        return $response;
    }
}
