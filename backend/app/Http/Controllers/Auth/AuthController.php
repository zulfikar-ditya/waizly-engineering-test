<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle login attempt.
     *
     * @param LoginRequest $request
     * @return ResponseJson
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->safe()->only(['email', 'password']);

        if (!Auth::attempt($credentials, $request->remember_mode)) {
            return response()->json([
                'message' => 'Invalid credentials.',
                'errors' => [
                    'password' => ['Invalid password.'],
                ]
            ], 401);
        }

        $user = \App\Models\User::find(Auth::user()->id);

        return $this->responseJsonData([
            'success' => Auth::check(),
            'token' => $user->createToken('sanctum')->plainTextToken,
            'user' => $user,
        ], "Success Authenticate");
    }

    /**
     * Handle the logout attempt.
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->responseJsonMessage('Logged out', 401);
    }
}
