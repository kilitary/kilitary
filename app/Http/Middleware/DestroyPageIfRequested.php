<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;

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

        $content = $response->getContent();

        $n = preg_match("#<body>(.*?)</body>#Usmi", $content, $matches);

        $body = $matches[1];
        preg_match_all("#class=['\"]*?([^'\"><\s]{1,120}?)['\"]*?#Usmi", $body, $matches, \PREG_SET_ORDER);

        $classes = collect([]);

        foreach($matches as $match) {
            if(!$classes->contains($match[1])) {
                $classes->add($match[1]);
            }
        }

        $done = 0;
        foreach($classes->toArray() as $class) {
            $body = str_replace($classes->random(1)->flatten()->toArray()[0], $classes->random(1)->flatten()->toArray()[0], $body, $done);
        }

        $content = \preg_replace("#</head>\s?<body>(.*?)</body>\s?</html>#smi", $body, $content, -1, $num);
        $response->setContent($content);

        return $response;
    }
}
