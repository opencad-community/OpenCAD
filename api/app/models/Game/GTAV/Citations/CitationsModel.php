<?php

namespace App\Models\Game\GTAV\Citations;

use Core\Database;

define("USER_ID", ":user_id");

/**
 * Citations model class that retrieves data from the citations table.
 */
class CitationsModel
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the Citations model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all citations from the citations table.
     *
     * @return array An array of citation objects.
     */
    public function getAllCitations()
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_citations');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single citation from the citations table by ID.
     *
     * @param int $id The ID of the citation to retrieve.
     *
     * @return array An array of citation objects.
     */
    public function getCitationById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_citations WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Adds a new citation to the citations table.
     *
     * @param array $data An array of citation data, including user_id, offence_type, offence_code, location_of_offence.
     *
     * @return int The ID of the newly inserted citation.
     */
    public function addCitation($data)
    {
        $stmt = $this->database->prepare(
            'INSERT INTO ncic_citations (user_id, offence_type, offence_code, location_of_offence)
            VALUES (:user_id, :offence_type, :offence_code, :location_of_offence)'
        );
        $stmt->bindParam(USER_ID, $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':offence_type', $data['offence_type'], \PDO::PARAM_STR);
        $stmt->bindParam(':offence_code', $data['offence_code'], \PDO::PARAM_STR);
        $stmt->bindParam(':location_of_offence', $data['location_of_offence'], \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Updates an existing citation in the ncic_citations table.
     *
     * @param int $id The ID of the citation to be updated.
     * @param array $data An array of citation data, including offence_code, date_of_offence, and location_of_offence.
     *
     * @return bool Returns true if the citation was successfully updated, false otherwise.
     */
    public function updateCitation($id, $data)
    {
        $stmt = $this->database->prepare(
            'UPDATE ncic_citations
        SET offence_code = :offence_code,
        date_of_offence = :date_of_offence,
        location_of_offence = :location_of_offence
        WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':offence_code', $data['offence_code'], \PDO::PARAM_STR);
        $stmt->bindParam(':date_of_offence', $data['date_of_offence'], \PDO::PARAM_STR);
        $stmt->bindParam(':location_of_offence', $data['location_of_offence'], \PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Deletes a citation from the ncic_citations table.
     *
     * @param int $id The ID of the citation to be deleted.
     *
     * @return bool Returns true if the citation was successfully deleted, false otherwise.
     */
    public function deleteCitation($id)
    {
        $stmt = $this->database->prepare('DELETE FROM ncic_citations WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}
