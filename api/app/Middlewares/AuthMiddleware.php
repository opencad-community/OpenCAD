<?php

namespace App\Middlewares;

use Core\Request;
use Core\Response;
use App\Core\TokenAuth;

class AuthMiddleware
{
    public function handle()
    {
        // Get the Authorization header from the request
        $header = Request::getHeader('Authorization');

        if (!$header) {
            // Authorization header not present
            $response = Response::unauthorized('Unauthorized');
            $response->send();
            exit();
        }

        // Get the token from the Authorization header
        $token = str_replace('Bearer ', '', $header);

        // Authenticate the user using the token
        $auth = new TokenAuth(3600); // Expires in 1 hour
        $userId = $auth->authenticate($token);

        if (!$userId) {
            // Token is invalid or has expired
            $response = Response::unauthorized('Unauthorized');
            $response->send();
            exit();
        }
    }
}
