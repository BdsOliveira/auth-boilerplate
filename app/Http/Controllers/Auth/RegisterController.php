<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        return RegisterService::register([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'device_name' => $request->device_name,
        ]);
    }
}
