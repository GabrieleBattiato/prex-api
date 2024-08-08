<?php

namespace App\Http\Middleware;

use App\Models\UserServiceInteraction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $res = $next($request);

        if($request->user()){
            $log = [
                'user_id' => $request->user()->id,
                'service' => $request->path(),
                'request_body' => empty($request->all()) ? new \stdClass() : $request->all(),
                'http_code' => $res->status(),
                'response_body' => json_decode($res->getContent()),
                'ip_origin' => $request->ip(),
            ];

            Log::channel('api_service')->info('Service Log:', $log);

            UserServiceInteraction::create($log);
        }

        return $res;
    }
}
