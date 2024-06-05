<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;

class LastUserActivity
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
        if(Auth::check()){
            
            $expiresAt = Carbon::now()->addMinutes(2);
            Cache::put('users-is-online-' . Auth::user()->id, true, $expiresAt);
            //return $next($request);
        }
         return $next($request);
        //else {
           // return redirect('/connexion');
        //} 
    }
}
