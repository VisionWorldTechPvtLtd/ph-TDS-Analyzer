<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CGWAAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     public function handle(Request $request, Closure $next)
    {
        if ($request->is('cgwa/login') || $request->is('cgwa/login*')) {
            return $next($request);
        }
        if (auth()->check() && auth()->user()->roles_id == 2) {
            return $next($request);
        }
    
        return redirect('/cgwa/login');
    }
}
