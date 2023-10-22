<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            if(Auth::user()->type == '1')//1=Admin
            {
                return $next($request);
            } 
            else //0=User
            { 
                return redirect()->back()->with('status','Access Denied! As you are not an Admin');
            }
        }
        else
        {
            return redirect('/login')->with('status','Please Login First');
        }
        
    }
}
