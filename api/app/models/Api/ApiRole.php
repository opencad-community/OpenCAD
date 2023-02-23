<?php

namespace App\Models\Api;

use Core\Database;

/**
 * ApiRole model class that retrieves data from the api_roles table.
 */
class ApiRole
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the ApiRole model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all api roles from the api_roles table.
     *
     * @return array An array of api role objects.
     */
    public function getAllApiRoles()
    {
        $stmt = $this->database->prepare('SELECT * FROM api_roles');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single api role from the api_roles table by ID.
     *
     * @param int $id The ID of the api role to retrieve.
     *
     * @return array An array of api role objects.
     */
    public function getApiRoleById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM api_roles WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Adds a new api role to the api_roles table.
     *
     * @param array $data An array of api role data, including name and description.
     *
     * @return int The ID of the newly inserted api role.
     */
    public function addApiRole($data)
    {
        $stmt = $this->database->prepare('INSERT INTO api_roles (name, description) VALUES (:name, :description)');
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Updates an existing API role in the database
     *
     * @param int $id The ID of the API role to be updated
     * @param array $data An array of API role data, including name and description
     *
     * @return bool Returns true if the API role was successfully updated, false otherwise
     */
    public function updateApiRole($id, $data)
    {
        $stmt = $this->database->prepare(
            'UPDATE api_roles SET name = :name, description = :description WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], \PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Deletes an API role from the database
     *
     * @param int $id The ID of the API role to be deleted
     *
     * @return bool Returns true if the API role was successfully deleted, false otherwise
     */
    public function deleteApiRole($id)
    {
        $stmt = $this->database->prepare('DELETE FROM api_roles WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }


}