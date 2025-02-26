<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CanRecoverToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if ($token) {
            $tokenRecord = PersonalAccessToken::findToken($token);

            if(!$tokenRecord){
                return response()->json([
                    'success' => false,
                    'message' => 'Token expirado o incorrecto'
                ], 200);
            }
            $user = User::find($tokenRecord->tokenable_id);
            if ($user) {
                Auth::setUser($user);
            }
        }

        return $next($request);
    }
}
