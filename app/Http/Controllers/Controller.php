<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//    public function __construct(Request $request,Route $route)
//    {
//            // check if user loged in get user id else set null for it .
//            $user_id = Auth::user();
//
//            $method = $route->getActionMethod();
//            $actions = explode('\\', $route->getActionName());
//            $controller = substr(end($actions), 0, strpos(end($actions), "@"));
//            dd($method);
//            Log::create([
//                'ip' => $request->ip(),
//                'agent' => detectAgent(),
//                'controller' => $controller,
//                'method' => $method,
//                'user_id' => $user_id,
//                'input' => $request->getContent(),
//                'route' => $request->path(),
//                'http_method' => $route->methods()[0],
//            ]);
//        }

//    public function __construct(Request $request,Route $route,User $user)
//    {
//        $user_id = User::all();
//        \App\Models\Loguser::create([
//            'ip' => $request->ip(),
//            'agent' => $request->header('User-Agent'),
//            'user_id' => $request->getUser(),
//            'route' => $request->path(),
//            'login' =>new DateTime("now"),
//            'logout'=>auth()->logout(),
//        ]);
//    }
}
