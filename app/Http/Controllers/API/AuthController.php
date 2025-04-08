<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Check if the user exists based on the email
        $user = User::where('email', $request->email)->first();
        
        // Check if the user exists and the password matches
        if (!$user || !password_verify($request->password, $user->confirmed_password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // If credentials are valid, create the token
        $token = $user->createToken('authToken')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }
    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
    
        return response()->json(['message' => 'Logged out successfully']);
    }
    
}
