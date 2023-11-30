<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        \App\Models\Loguser::create([
            'ip' => $request->ip(),
            'agent' => $request->header('User-Agent'),
            'user_id' => Auth::user(),
            'route' => $request->path(),
            'login' =>new DateTime("now"),
            'logout'=>auth()->logout(),
        ]);

        return $next($request);
    }
}
