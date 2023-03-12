<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // If the credentials are invalid, return an error response
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
        ], 200);
    }
}
