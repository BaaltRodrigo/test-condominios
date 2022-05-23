<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // Try credentials
        if(!auth()->attempt($request->validated()))
        {
            return response(['message' => 'Unauthorized'], 401);
        }

        // Credentials OK
        $user = auth()->user();
        $newToken = $user->createToken('token')->plainTextToken;

        // Create cookie token
        // Not now. Just acces_token to localStorage
        // $cookie = cookie('jwt', $newToken, -1); // Token last forever

        return response([
                'message' => 'Success',
                'access_token' => $newToken
            ]);
    }

    public function me(Request $request)
    {
        return auth()->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response(['message' => 'Success']);
    }
}
