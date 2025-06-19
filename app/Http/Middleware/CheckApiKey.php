<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey || !User::where('api_key', $apiKey)->exists()) {
            return Response::json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}