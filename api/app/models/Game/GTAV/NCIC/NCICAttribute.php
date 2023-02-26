<?php

namespace App\Models\Game\GTAV\NCIC;

use Core\Database;

/**
 * Attribute model class that retrieves data from the ncic_attributes table.
 */
class NCICAttribute
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the Attribute model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all attributes from the ncic_attributes table.
     *
     * @return array An array of attribute objects.
     */
    public function getAllAttributes()
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_attributes');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single attribute from the ncic_attributes table by ID.
     *
     * @param int $id The ID of the attribute to retrieve.
     *
     * @return array An array of attribute objects.
     */
    public function getAttributeById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_attributes WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves the names of the attributes with the given IDs.
     *
     * @param array $ids An array of attribute IDs.
     *
     * @return array An array of attribute names.
     */
    public function getAttributeNamesByIds($ids)
    {
        // Use the implode function to join the IDs into a comma-separated string
        $idList = implode(',', $ids);

        // Prepare the SQL statement to retrieve the names of the attributes with the given IDs
        $stmt = $this->database->prepare("SELECT name FROM ncic_attributes WHERE id IN ({$idList})");

        // Execute the statement and retrieve the results
        $this->database->executeStatement($stmt);
        $results = $this->database->resultSet($stmt);

        // Extract the attribute names from the results and return them in an array
        $names = array();
        foreach ($results as $result) {
            $names[] = $result['name'];
        }
        return $names;
    }

    /**
     * Adds a new attribute to the ncic_attributes table.
     *
     * @param array $data An array of attribute data, including name and type.
     *
     * @return int The ID of the newly inserted attribute.
     */
    public function addAttribute($data)
    {
        $stmt = $this->database->prepare('INSERT INTO ncic_attributes (attribute_name) VALUES (:attribute_name)');
        $stmt->bindParam(':attribute_name', $data['attribute_name'], \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Updates an existing attribute in the ncic_attributes table.
     *
     * @param int $id The ID of the attribute to be updated.
     * @param array $data An array of attribute data, including name and type.
     *
     * @return bool Returns true if the attribute was successfully updated, false otherwise.
     */
    public function updateAttribute($id, $data)
    {
        $stmt = $this->database->prepare('UPDATE ncic_attributes SET attribute_name = :attribute_name WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':attribute_name', $data['attribute_name'], \PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Deletes an attribute from the ncic_attributes table.
     *
     * @param int $id The ID of the attribute to delete.
     *
     * @return bool Returns true if the attribute was successfully deleted, false otherwise.
     */
    public function deleteAttribute($id)
    {
        $stmt = $this->database->prepare('DELETE FROM ncic_attributes WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}