<?php

namespace App\Models\Game\GTAV\NCIC;

use Core\Database;

/**
 * NCICUserAttribute model class that retrieves data from the ncic_user_attribute table.
 */
class NCICUserAttribute
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the NCICUserAttribute model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all attributes for a particular NCIC user.
     *
     * @param int $userId The ID of the NCIC user.
     * @return array An array of attribute objects.
     */
    public function getAttributesForUser($userId)
    {
        $stmt = $this->database->prepare('SELECT ncic_attributes.attribute_name as attribute_name, ncic_user_attributes.attribute_value, ncic_user_attributes.attribute_id FROM ncic_user_attributes LEFT JOIN ncic_attributes ON ncic_user_attributes.attribute_id = ncic_attributes.id WHERE user_id = :users_id');
        $stmt->bindParam(':users_id', $userId, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }


    /**
     * Adds a new attribute for a particular NCIC user to the ncic_user_attribute table.
     * 
     * @param int $userId The ID of the NCIC user.
     * @param string $attributeName The name of the attribute to add.
     * 
     * @return int The ID of the newly inserted attribute.
     */
    public function addAttributeForUser($userId, $attributeName)
    {
        $stmt = $this->database->prepare('INSERT INTO ncic_user_attributes (user_id, attribute_name) VALUES (:userId, :attributeName)');
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':attributeName', $attributeName, \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Deletes an attribute for a particular NCIC user from the ncic_user_attribute table.
     * 
     * @param int $userId The ID of the NCIC user.
     * @param int $attributeId The ID of the attribute to be deleted.
     * 
     * @return bool Returns true if the attribute was successfully deleted, false otherwise.
     */
    public function deleteAttributeForUser($userId, $attributeId)
    {
        $stmt = $this->database->prepare('DELETE FROM ncic_user_attributes WHERE user_id = :userId AND id = :attributeId');
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':attributeId', $attributeId, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Updates an attribute for a specific NCIC user.
     *
     * @param int $userId The ID of the NCIC user to update.
     * @param string $attributeName The name of the attribute to update.
     * @param string $attributeValue The new value of the attribute.
     *
     * @return bool Returns true if the attribute was updated successfully, false otherwise.
     */
    public function updateAttributeForUser($userId, $attributeName, $attributeValue)
    {
        // Check if the attribute exists for this user
        $stmt = $this->database->prepare('SELECT id FROM ncic_attributes WHERE name = :attributeName');
        $stmt->bindParam(':attributeName', $attributeName, \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        $attributeId = $this->database->resultSet($stmt);
        $attributeId = $attributeId["id"];

        if (!$attributeId) {
            // If the attribute does not exist, return false
            return false;
        }

        // Check if the user already has a value for this attribute
        $stmt = $this->database->prepare('SELECT id FROM ncic_user_attributes WHERE user_id = :userId AND attribute_id = :attributeId');
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':attributeId', $attributeId, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        $userAttributeId = $this->database->resultSet($stmt);
        $userAttributeId = $userAttributeId["id"];

        if ($userAttributeId) {
            // If the user already has a value for this attribute, update the value
            $stmt = $this->database->prepare('UPDATE ncic_user_attributes SET value = :attributeValue WHERE id = :userAttributeId');
            $stmt->bindParam(':userAttributeId', $userAttributeId, \PDO::PARAM_INT);
            $stmt->bindParam(':attributeValue', $attributeValue, \PDO::PARAM_STR);
            return $this->database->executeStatement($stmt);
        } else {
            // If the user does not have a value for this attribute, insert a new row
            $stmt = $this->database->prepare('INSERT INTO ncic_user_attributes (user_id, attribute_id, value) VALUES (:userId, :attributeId, :attributeValue)');
            $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':attributeId', $attributeId, \PDO::PARAM_INT);
            $stmt->bindParam(':attributeValue', $attributeValue, \PDO::PARAM_STR);
            return $this->database->executeStatement($stmt);
        }

    }

    /**
     * Deletes all attributes for a given NCIC user ID.
     *
     * @param int $userId The ID of the NCIC user to delete attributes for.
     * @return bool Returns true if the attributes were successfully deleted, false otherwise.
     */
    public function deleteAllAttributesForUser($userId)
    {
        $stmt = $this->database->prepare('DELETE FROM ncic_user_attribute WHERE user_id = :userId');
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}