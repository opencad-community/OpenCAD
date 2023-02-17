<?php
namespace App\Models;

use Core\Database;

class User
{
    private $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function getAllUsers()
    {
        $stmt = $this->database->prepare('SELECT * FROM users');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    public function getUserById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    public function addUser($data)
    {
        $stmt = $this->database->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return $this->database->lastInsertId();
    }

    public function updateUser($id, $data)
    {
        $stmt = $this->database->prepare('UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':password', $data['password'], \PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    public function deleteUser($id)
    {
        $stmt = $this->database->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}