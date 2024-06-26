<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function getUser()
    {
        $user = auth('api')->user();
        return response()->json(['user'=>$user], 201);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        $user = new User([
            'name'=> $request->input('name'),
            'email'=> $request->input('email'),
            'password'=> bcrypt($request->input('password'))
        ]);

        $user->save();

        return response()->json([
            'message'=>'Successfully Created user'
        ],201);
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 500);
        }
        return response()->json([
            'token' => $token
        ], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
