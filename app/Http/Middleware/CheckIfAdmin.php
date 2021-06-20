<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckIfAdmin
{
    public function handle(Request $request, Closure $next)
    {

        if ($request->user()->is_admin) {
            return $next($request);
        }

        return response()->json([
            'message' => "Unauthorized",
            'success' => false,
        ], 401);
    }
}
