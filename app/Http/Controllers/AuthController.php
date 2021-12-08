<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{

    public function signup(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|string|unique:users,email',
            'password'=> [
                'required',
                'confirmed',
                'max:64',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(['!','@','#','$','%','^','-','_','+','='])
            ]
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
        $user = User::create($attributes);
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

        // if(Auth::attempt($attributes)) {
        //     $request->session()->regenerate(); // without session?!
        //     //$user = User::where('email')->first();
        //     $user = $attributes;
        //     $token = $user->createToken('myapptoken')->plainTextToken;

        //     $response = [
        //         'user' => $user,
        //         'token' => $token
        //     ];
        //     return response($response, 201);
        //     //return response('you are logged in.', 200);
        // } else {
        //     return response([
        //         'message' => 'Bad Credentials'
        //     ], 401); //Login Invalid 401 or 503?
        // }

        if(!Auth::attempt($attributes))
        {
            return response()->json([
                'message' => 'Credentials do not match'
            ], 401);
        }

        $user = User::where('email', $attributes['email'])->firstOrFail();
        //$user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'access_token' => $token,
           'token_type' => 'Bearer',
        ]);

        // return $this->success([
        //     'token' => auth()->user()->createToken('API Token')->plainTextToken
        // ]);

    }

    //signing out user by revoking token
    public function signout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Token is Revoked'
        ];
        //Auth::logout();
        //return response('logged out');
    }
}
