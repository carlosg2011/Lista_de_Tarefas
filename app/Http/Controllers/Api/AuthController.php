<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'user' => $user,
        ], 201);
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if (empty($token)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'data' => [
                'token_type' => 'bearer',
                'token' => $token,
                'expires_in' => date('Y-m-d H:i:s', strtotime('+' . 120 * 60))
            ]
        ]);
    }
}
