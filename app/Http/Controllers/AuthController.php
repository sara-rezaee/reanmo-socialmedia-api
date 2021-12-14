<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    public function signup(StoreUserRequest $request)
    {
        $attributes = $request->validated();

        $user = User::create($attributes);
        $user = new UserResource($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function signin(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($attributes)) {
            return response()->json([
                'message' => 'Credentials do not match'
            ], 401);
        }

        $user = Auth::user();
        $user = new UserResource($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
           'user' => $user,
        ]);
    }

    //signing out user by revoking token
    public function signout()
    {
        Auth::user()->tokens()->delete();
        Auth::guard('web')->logout();

        return [
            'message' => 'Token is Revoked'
        ];
    }
}
