<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Vérifiez si l'utilisateur est un administrateur
        if ($user->role !== User::ROLES['admin']) {
            return response()->json(["message" => "Unauthorized access. Only admins can validate accounts."], 403);
        }

        return $next($request);
    }
}
