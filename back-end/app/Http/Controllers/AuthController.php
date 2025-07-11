<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'country' => $request->input('country'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => UserResource::make($user),
            ]
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        // if(!Auth::attempt($request->only('email', 'password')))     

        $user = User::where('email', $request->input('email'))->first();
        if(!$user || !password_verify($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'data' => [
                'user' => UserResource::make($user),
                'access_token' => $accessToken,
            ]
        ], 200);
    }

    public function profile()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => UserResource::make(Auth::user()),
            ]
        ], 200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully',
        ], 200);
    }
}
