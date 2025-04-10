<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    protected $session;
    protected $timeout = 1800; // 30 minutes in seconds

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('last_activity')) {
            $request->session()->put('last_activity', time());
        }
        
        if (time() - $request->session()->get('last_activity') > $this->timeout) {
            $request->session()->flush();
            Auth::logout();
            return redirect()->route('login')->with('message', 'Your session has expired. Please login again.');
        }

        $request->session()->put('last_activity', time());
        return $next($request);
    }
}