<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasId = session()->has('id');
        if ($request->is('login')) {
            if ($hasId) {
                return redirect()->route('dashboard');
            } else {
                return $next($request);
            }
        }

        if ($hasId) {
            return $next($request);
        }
        return redirect()->route('page.login');
    }
}
