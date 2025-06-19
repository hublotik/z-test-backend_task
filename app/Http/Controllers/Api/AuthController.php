<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed (email/password)',
                'errors' => $e->errors()
            ], 422);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $apiKey = User::getApiKeyByCredentials($email, $password);

        if ($apiKey) {
            return response()->json(['api_key' => $apiKey]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}