<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckUserExists
{
    public function handle($request, Closure $next)
    {
        $user = $request->route('user');
        if (!$user) {
            return response()->json(['error' => 'User with this id does not exist'], 404);
        }

        return $next($request);
    }
}
