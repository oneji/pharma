<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class CheckUserChangedPassword
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
        $currentUser = Auth::user();

        if(Auth::check()) {
            if(Auth::user()->password_changed === 0) {
                return redirect()->route('password.edit');
            }
        } else {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
