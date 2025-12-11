<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        // Dev token bypass
        if ($request->bearerToken() === env('TESTING_API_TOKEN')) {
            Auth::login(User::find(5));
            return $next($request);
        }

        // Normal auth
        if (! $request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}
