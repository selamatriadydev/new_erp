<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class financemiddleware
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
        if(Auth::user()->hak_akses != 'Finance' && Auth::check()){
            return redirect(route('home'))->with('pesan','Anda tidak punya hak akses');
        }
        return $next($request);
    }
}
