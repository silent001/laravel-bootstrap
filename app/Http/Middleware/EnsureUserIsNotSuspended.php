<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsNotSuspended
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
        if(!auth()->check())
        {
            return redirect()->route('login');
        }
        
        if(auth()->user()->suspended_till) 
        {
            $suspened_till = auth()->user()->suspended_till;
        }
        else
        {
            $suspened_till = now();
        }

        if($suspened_till->gte(now()))
        {
            return redirect()->route('suspended');
        }
        return $next($request);
    }
}
