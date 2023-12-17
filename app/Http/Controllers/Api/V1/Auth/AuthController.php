<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user();

        $user->tokens()->delete();

        return response()->json(['message' => 'Logout successfully'], 200);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make($request->password),
        ]);

        // $token = $user->createToken($request->device_name)->plainTextToken;

        // return response()->json(['token' => $token]);

        $user->sendEmailVerificationNotification(); // Envia o e-mail de verificação

        return response()->json(['message' => 'User registered successfully. Please check your email for verification.']);
    }
}
