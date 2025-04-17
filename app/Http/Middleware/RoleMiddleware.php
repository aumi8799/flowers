<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::user() || Auth::user()->role !== $role) {
            return redirect('/');
        }

        return $next($request);
    }
}