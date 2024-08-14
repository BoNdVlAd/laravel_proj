<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestsResponses
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);

        $contents = json_decode($response->getContent(), true, 512);

        $dt = Carbon::now();
        $data = [
            'path'         => $request->getPathInfo(),
            'method'       => $request->getMethod(),
            'ip'           => $request->ip(),
            'http_version' => $_SERVER['SERVER_PROTOCOL'],
            'timestamp'    => $dt->toDateTimeString(),
        ];

        $logLevel = 'info';

        if ($response->getStatusCode()) {
            $data['status_code'] = $response->getStatusCode();
        }

        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        if (count($request->all()) > 0) {
            $hiddenKeys = ['password'];
            $data['request'] = $request->except($hiddenKeys);
        }

        if(!empty($contents)){
            $data['response'] = $contents;
        }

        if (!empty($contents['message'])) {
            $data['response']['message'] = $contents['message'];
        }

        if (!empty($contents['message'])) {
            $data['response']['message'] = $contents['message'];
        }

        if (!empty($contents['errors']) || $response->getStatusCode() !== 200) {
            $data['response'] = $contents['errors'] ?? '';
            $logLevel = 'error';
        }

        if (!empty($contents['result'])) {
            $data['response']['result'] = $contents['result'];
        }

        if (!empty($response->exception)) {
            $data['response'] = $response->exception->getMessage();
            $logLevel = 'error';
        }

        if ($response->getStatusCode() === 500) {
            $logLevel = 'warning';
        }

        if ($response->getStatusCode() !== 500) {
            $data['response'] = $contents['message'] ?? $contents;
            $logLevel = 'error';
        }

        $userId = $request->user() ? $request->user()->id : 'guest';
        $logDirectory = storage_path("logs/{$dt->year}/{$dt->month}/{$dt->day}/user_{$userId}");

        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }

        $userName = $request->user() ? $request->user()->name : 'guest';
        $logFileName = "{$logDirectory}/{$userName}.log";

        Log::build([
            'driver' => 'single',
            'path' => $logFileName,
        ])->$logLevel('Request Log', $data);

        return $response;
    }
}
