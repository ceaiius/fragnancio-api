<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateCredentialsRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!$token = JWTAuth::attempt($validated)) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }

        return response()->json(['token' => $token]);
    }

     public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function updateCredentials(UpdateCredentialsRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = auth()->user();

        if (isset($validated['username'])) {
            $user->username = $validated['username'];
        }

        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        if (isset($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'Credentials updated successfully',
            'user' => $user
        ]);
    }
}
