<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;


class RegisterService
{
    public static function register(array $credentials) : JsonResponse {

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        return LoginService::authenticate([
            'email' => $user->email,
            'password' => $credentials['password'],
            'device_name' => $credentials['device_name'],
        ]);
    }
}
