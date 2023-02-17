<?php

namespace App\Models\Game;

use Core\Database;
use PDO;

class StreetModel
{
    private $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }
    /**
     * Get all streets records from the database.
     *
     * @return array An array of street objects.
     */
    public function getAllStreets()
    {
        $stmt = $this->database->prepare('SELECT * FROM streets');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Get a single street record from the database by ID.
     *
     * @param int $id The ID of the street to retrieve.
     *
     * @return object|false The street object if it was found, false otherwise.
     */
    public function getStreetById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM street WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Add a new street to the database.
     *
     * @param array $data An array of street data.
     *
     * @return int The ID of the newly inserted street.
     */
    public function addStreet($data)
    {

        try {
            $stmt = $this->database->prepare('INSERT INTO streets (name, county) VALUES (:name, :county)');
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':county', $data['county'], PDO::PARAM_STR);
            $this->database->executeStatement($stmt);
            return (int) $this->database->lastInsertId();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing street in the database.
     *
     * @param int $id The ID of the street to update.
     * @param array $data An array of street data.
     *
     * @return bool Returns true if the street was updated successfully, false otherwise.
     */
    public function updateStreet($id, $data)
    {
        $stmt = $this->database->prepare('UPDATE streets SET name = :name, county = :county WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':county', $data['county'], PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    /**
     * deleteStreet function is used to delete a street from the streets table.
     *
     * @param int $id The ID of the street that needs to be deleted.
     *
     * @return bool Returns true if the street was successfully deleted, false otherwise.
     */
    public function deleteStreet($id)
    {
        $stmt = $this->database->prepare("DELETE FROM streets WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}