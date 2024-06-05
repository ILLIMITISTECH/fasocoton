<?php

namespace App\Http\Middleware;
use DB;
use Closure;
use Auth;
use DateTime;
use Carbon\Carbon;
class LastOnlineAt
{
    public function handle($request, Closure $next)
    {
        
        if (Auth()->guest()) {
            return $next($request);
        }
        if (auth()->user()->last_online_at != Carbon::now())
        { 
            DB::table("users")
              ->where("id", Auth()->user()->id)
              ->update(["last_online_at" => now()]);
        }
        return $next($request);
    }
}