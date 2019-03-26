<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminChecker
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
        if (Auth::user()->user_type == 1){
            return Redirect::home();
        }else if(Auth::user()->user_type == 2){
            return \redirect()->route('writer.orders.available');
        }else if (Auth::user()->user_type == 3) {
            return \redirect()->route('customer.orders.list');

        }else{
                return $next($request);
            }

    }
}
