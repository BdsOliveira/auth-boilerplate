<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;


class LoginService
{
    public static function authenticate(array $credentials) {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new InvalidCredentialsException(
                'User email or password does not match.',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $user->createToken($credentials['device_name'])->plainTextToken;
        Auth::login($user);

        return new JsonResponse([
            'message' => 'Success.',
            'token' => $token,
            'user' => new UserResource($user),
        ], Response::HTTP_OK);
    }
}
