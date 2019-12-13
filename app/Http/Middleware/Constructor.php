<?php

namespace App\Http\Middleware;

use Closure;

class Constructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->segment(1) != 'constructor') {
            return redirect()->route('construction_route');
        }
        return $next($request);
    }
}
