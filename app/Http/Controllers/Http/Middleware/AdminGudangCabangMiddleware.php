<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminGudangcabangMiddleware
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
        if(Auth::check() && Auth::user()->hak_akses != 'Admin Gudangcabang' ) {
        return redirect(route('home'))->with('pesan','Anda tidak punya hak akses');
    }

        return $next($request);
    }
}
