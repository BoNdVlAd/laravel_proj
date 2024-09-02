<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $response = $next($request);
//        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3006');
//        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
//        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
//        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
