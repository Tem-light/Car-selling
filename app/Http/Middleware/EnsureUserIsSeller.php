<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSeller
{
    /**
     * Handle an incoming request.
     * Allows sellers and admins to manage car listings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->canManageListings()) {
            return $next($request);
        }

        return redirect()->route('dashboard')
            ->with('error', 'Only sellers can create or manage car listings. Update your account type in settings.');
    }
}
