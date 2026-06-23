<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FirebaseTokenVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class FirebaseAuthController extends Controller
{
    public function __construct(private FirebaseTokenVerifier $verifier) {}

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $claims = $this->verifier->verifyIdToken($validated['id_token']);
        } catch (RuntimeException $exception) {
            throw ValidationException::withMessages([
                'id_token' => [$exception->getMessage()],
            ]);
        }

        $user = User::firstOrCreate(
            ['email' => $claims['email']],
            [
                'name' => $claims['name'] ?? $claims['email'],
                'password' => Hash::make(Str::random(40)),
            ]
        );

        $token = $user->createToken('firebase_auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authenticated via Firebase successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
