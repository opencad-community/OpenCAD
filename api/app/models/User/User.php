<?php
namespace App\Models\User;

use Core\Database;

/**
 * User model class that retrieves data from the users table.
 */
class User
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the User model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all users from the users table.
     *
     * @return array An array of user objects.
     */
    public function getAllUsers()
    {
        $stmt = $this->database->prepare('SELECT * FROM users');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single user from the users table by ID.
     *
     * @param int $id The ID of the user to retrieve.
     *
     * @return array An array of user objects.
     */
    public function getUserById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }
    /**
     * Adds a new user to the users table.
     * 
     * @param array $data An array of user data, including name, email, and password.
     * 
     * @return int The ID of the newly inserted user.
     */
    public function addUser($data)
    {
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
        $stmt = $this->database->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Updates an existing user in the users table.
     * 
     * @param int $id The ID of the user to be updated.
     * @param array $data An array of user data, including name, email, and password.
     * 
     * @return bool Returns true if the user was successfully updated, false otherwise.
     */
    public function updateUser($id, $data)
    {
        $stmt = $this->database->prepare('UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], \PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Deletes a user from the users table.
     * 
     * @param int $id The ID of the user to be deleted.
     * 
     * @return bool Returns true if the user was successfully deleted, false otherwise.
     */
    public function deleteUser($id)
    {
        $stmt = $this->database->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}