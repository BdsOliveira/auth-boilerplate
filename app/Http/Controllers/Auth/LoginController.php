<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'User email or password does not match.',
            ], Response::HTTP_NOT_FOUND);
        }

        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'message' => 'User logged in succesfully.',
            'token' => $token,
            'user' => new UserResource($user),
        ], Response::HTTP_OK);
    }
}
