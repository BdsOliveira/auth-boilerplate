<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidCredentialsException extends Exception
{
    protected $code = Response::HTTP_UNAUTHORIZED;
    protected $message = "User email or password does not match.";

    public function render() {
        return new JsonResponse([
            'message' => $this->message,
            'errors' => [
                'message' => $this->message
            ],
        ], $this->code);
    }
}
