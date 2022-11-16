<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class HelpdeskMiddleware
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
        if(Auth::user()->hak_akses != 'Helpdesk' && Auth::check() && Auth::user()->userstatus != 'aktif' ){
            return redirect(route('home'))->with('pesan','Anda tidak punya hak akses');
        }
        return $next($request);
    }
}
