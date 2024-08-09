<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class LogMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(
        Logger $logger,
    ) {
        $this->logger = $logger;
    }
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $this->logger->info('Dump request', [
            'request' => serialize($request),
            'response' => serialize($response),
        ]);

        return $response;
    }
}

