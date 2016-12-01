<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
       /*
         if (count(Auth::user()->roles)>0){
           foreach (Auth::user()->roles as $key => $role) {
             if ($role->role != 'admin')
             {
             }
             return redirect('home');
           }
           return $next($request);
         } else{
           return redirect('home');
         }
       */
       if (Auth::user()->perms["admin"]==1){
           return $next($request);
       }
       #return $next($request);
       return redirect('home');
     }
}
