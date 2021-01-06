<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Closure;

class Role
{
    public function handle($request, Closure $next, $role)
    {
        $roles = explode('|', $role);
        if(auth()->check() && in_array(auth()->user()->role_id, $roles)){
            return $next($request);
        }elseif($request->wantsJson()){
            return response()->json('Unauthenticated.', 401);
        }else{
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
