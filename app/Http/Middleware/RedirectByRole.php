<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if (in_array($role, ['admin', 'manajemen_driver', 'senior_manager'])) {
                return redirect()->route('admin.dashboard');
            }

            if ($role === 'sopir') {
                return redirect()->route('sopir.dashboard');
            }
        }

        return $next($request);
    }
}