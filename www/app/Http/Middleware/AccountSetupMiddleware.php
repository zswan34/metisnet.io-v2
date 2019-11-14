<?php

namespace App\Http\Middleware;

use Closure;

class AccountSetupMiddleware
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
        if (auth()->check()) {
            if (!auth()->user()->account->isSetup())
            {
                return redirect()->route('get-setup');
            }
        }
        return $next($request);
    }
}
