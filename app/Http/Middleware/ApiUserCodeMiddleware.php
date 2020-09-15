<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use DB;
use Lang;

class ApiUserCodeMiddleware
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
        if ($request->header('X-User-Code')) {
            $token = DB::table('users')->where('user_code', $request->header('X-User-Code'))->first();

            if (empty($token)) {
                return response()->json([
                    'success' => false,
                    'message' => Lang::get('messages.api_headers.invalid_user_code')
                ], 403);
            } else {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => Lang::get('messages.api_headers.user_code_missing')
        ], 401);
    }
}
