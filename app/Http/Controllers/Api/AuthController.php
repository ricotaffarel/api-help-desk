<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password does not match with our record.',
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken("authToken")->plainTextToken;
        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'datauser' => auth()->user(),
            'token' => $token
        ], 200);

    }

    function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'level' => 2,
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'The user has successfully registered',
                'datauser' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

    }

    function logout(Request $request)
    {
        // Revoke Token
        $token = auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logout Successfully',
            'token' => $token
        ], 200);

    }

    function fetch(Request $request)
    {
        // Revoke Token
        $user = auth()->user();

        return response()->json([
            'status' => true,
            'message' => 'Get data user successfully',
            'user' => $user
        ], 200);

    }
}