<?php

namespace App\Http\Middleware;

use App\frontmodels\Present;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ProfileCheck
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
        if (auth()->check() && isset(auth()->user()->mobile) && isset(auth()->user()->phone) && isset(auth()->user()->address) && isset(auth()->user()->postcode)){
            return $next($request);
        }

//        if (Auth::check() && isset(Auth::user()->mobile)){
//            return $next($request);
//        }

        Session::put('form-data', [
            'data'  => $request->except(['token']),
        ]);
//        dd($request->except(['token']));
        $msg = 'برای ادامه فرایند ثبت سفارش ، لازم است اطلاعات پروفایل کاربری خود را تکمیل کنید!';
        return redirect(route('profileedite',Auth::user()->id))->with('warning',$msg);
    }
}
