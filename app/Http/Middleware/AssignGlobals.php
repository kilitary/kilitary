<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\XRandom;
use Closure;
use Illuminate\Http\Request;

class AssignGlobals
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $colors = ['red', 'cyan', 'yellow', 'white', 'blue', 'pink'];

        $index = 3;
        if (XRandom::get(0, 10) == 7) {
            $index = XRandom::scaled(0, count($colors) - 1);
        }

        view()->share('centerColor', $colors[$index]);

        return $next($request);
    }
}
