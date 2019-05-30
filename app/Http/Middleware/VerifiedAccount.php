<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifiedAccount
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
        if(!Auth::user()->verified)
        {
            return redirect()->route('verifications.index')->with('message', 'We cannot process your order, as your account is still not verified! Please complete your verification.');
        }
        return $next($request);
    }
}
