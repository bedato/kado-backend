<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use DB;
use Lang;

class ApiAccessTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('X-Request-Timestamp')) {
            return response()->json([
                'success' => false,
                'message' => Lang::get('messages.api_headers.timestamp_missing')
            ], 401);
        } else {
            if (time() - $request->header('X-Request-Timestamp') > 300) {
                return response()->json([
                    'success' => false,
                    'message' => Lang::get('messages.api_headers.invalid_timestamp')
                ], 401);
            }
        }

        if ($request->header('X-Access-Token')) {
            $token = DB::table('merchants')->where('api_token', $request->header('X-Access-Token'))->first();

            if (empty($token)) {
                return response()->json([
                    'success' => false,
                    'message' => Lang::get('messages.api_headers.invalid_token')
                ], 403);
            } else {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => Lang::get('messages.api_headers.token_missing')
        ], 401);
    }
}
