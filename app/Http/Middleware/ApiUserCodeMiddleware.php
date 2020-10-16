<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use DB;

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
                    'message' => 'Invalid User Code'
                ], 403);
            } else {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'User Code Missing'
        ], 401);
    }
}
