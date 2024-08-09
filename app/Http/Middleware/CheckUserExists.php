<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckUserExists
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $user = $request->route('user');
        if (!$user) {
            return response()->json(['error' => 'User with this id does not exist'], 404);
        }

        return $next($request);
    }
}
