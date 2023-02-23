<?php
namespace App\Core;

use PDO;
use Core\Database;
use Core\Response;

define("TOKEN", ":token");

class TokenAuth
{
    protected $db;
    protected $expiry;


    public function __construct($expiry = 3600)
    {
        $this->db = Database::getInstance();
        $this->expiry = $expiry;
    }

    public function authenticate($token)
    {
        // Get the user ID associated with the token
        $query = "SELECT user_id FROM tokens WHERE token = :token AND expires_at >= NOW()";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(TOKEN, $token);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            $query = "DELETE FROM tokens WHERE token = :token";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(TOKEN, $token);
            $stmt->execute();
            $response = Response::unauthorized("Token Expired or doesn't exist.");
            $response->send();
            exit();
        }

        // Update the expiration time of the token
        $query = "UPDATE tokens SET expires_at = DATE_ADD(NOW(), INTERVAL :expiry SECOND) WHERE token = :token";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':expiry', $this->expiry);
        $stmt->bindParam(TOKEN, $token);
        $stmt->execute();

        // Return the user ID associated with the token
        return $result[0]['user_id'];
    }

    public function isAuthenticated()
    {
        // Get the HTTP Authorization header
        $authHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '';

        // Extract the token from the header
        $token = preg_replace('/Bearer\s/', '', $authHeader);

        // Authenticate the token
        return $this->authenticate($token);
    }

    /**
     * Generates a new token for the given user ID and stores it in the database.
     *
     * @param int $userId The ID of the user to generate a token for.
     * @return string|bool The generated token on success, or false on failure.
     */
    public function generateToken(int $userId)
    {
        // Generate a new token
        $token = strtr(base64_encode(random_bytes(125)), '+/', '-_');

        $date = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        // Store the token in the database for the given user ID
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO tokens (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(TOKEN, $token);
        $stmt->bindParam(":expires_at", $date);
        if ($db->executeStatement($stmt)) {
            // Return the generated token on success
            return $token;
        } else {
            // Return false on failure
            return false;
        }
    }
}
