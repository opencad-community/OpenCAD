<?php

namespace App\Controllers\Api;

use Core\Request;
use Core\Database;
use Core\Response;
use App\Core\TokenAuth;
use Opencad\App\Helpers\Exceptions\Generic\InternalServerErrorException;

class AuthController
{
    /**
     * Generates a new bearer token
     *
     * @param Request $request The request object
     *
     * @return void
     */
    public function generateToken()
    {
        try {
            // Get the email and password from the request body
            $body = Request::getData();

            // Make sure variables exist.
            if (!isset($body["email"]) || !isset($body["password"])) {
                $response = Response::error("Invalid request: email and password are required");
                return $response->send();
            }

            // Get the username and password from the request body
            $email = $body['email'];
            $password = $body['password'];

            // Retrieve the hashed password from the database for the given email
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $db->executeStatement($stmt);
            $results = $db->resultSet($stmt);

            // If results is empty, then throw error.
            if (!$results) {
                $response = Response::error('Invalid email or password');
                $response->send();
                exit();
            }
            // Set password variable.
            $hashPassword = $results[0]["password"];

            // Check if the provided password is correct
            if (password_verify($password, $hashPassword)) {
                // Generate a token
                $auth = new TokenAuth();
                $token = $auth->generateToken($results[0]["id"]);

                // Return the token in the response
                $response = Response::success(['token' => $token]);
                $response->send();
            } else {
                // If the password is incorrect, return an error response
                $response = Response::error('Invalid email or password');
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an error occurs, send an error response with the exception message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }
}
