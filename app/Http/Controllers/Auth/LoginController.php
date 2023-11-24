<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        return LoginService::authenticate([
                'email' => $request->email,
                'password' => $request->password,
                'device_name' => $request->device_name,
            ]);
    }
}
