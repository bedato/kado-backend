<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Log;

class LoginController extends Controller
{
    /**
     * Login processing
     *
     * @param LoginRequest $request - incoming request
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!empty($user)) {
            if (!Hash::check($credentials['password'], $user->password)) {
                return response()->json(['message' => 'Password is wrong. Please try again!']);
            }
            Log::debug('Admin LoginController - login: user found; giving user_code: ' . $user->user_code);
            return response()->json(['user_code' => $user->user_code]);
        }
        Log::debug('Admin LoginController login: wrong credentials');
        return response()->json(['message' => 'E-Mail is wrong. Please try again!']);
    }
}
