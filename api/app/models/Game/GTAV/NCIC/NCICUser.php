<?php

namespace App\Models\Game\GTAV\NCIC;

use Core\Database;

/**
 * NCICUser model class that retrieves data from the ncic_users table.
 */
class NCICUser
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the NCICUser model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all NCIC users from the ncic_users table.
     *
     * @return array An array of NCIC user objects.
     */
    public function getAllNCICUsers()
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_users');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single NCIC user from the ncic_users table by ID.
     *
     * @param int $id The ID of the NCIC user to retrieve.
     *
     * @return array An array of NCIC user objects.
     */
    public function getNCICUserById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_users WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single NCIC user from the ncic_users table by User Id.
     *
     * @param int $id The ID of the NCIC user to retrieve.
     *
     * @return array An array of NCIC user objects.
     */
    public function getNCICUserByUserId($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM ncic_users WHERE users_id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Adds a new NCIC user to the ncic_users table.
     *
     * @param array $data An array of NCIC user data, including user_id, first_name, last_name and created_at.
     *
     * @return int The ID of the newly inserted NCIC user.
     */
    public function addNCICUser($data)
    {
        $date = date('Y-m-d H:i:s');
        $stmt = $this->database->prepare(
            'INSERT INTO ncic_users
            (users_id, first_name, last_name, created_at)
            VALUES (:user_id, :first_name, :last_name, :created_at)'
        );
        $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':first_name', $data['first_name'], \PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], \PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $date, \PDO::PARAM_STR);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Updates an existing NCIC user in the database.
     *
     * @param int $id The ID of the NCIC user to be updated.
     * @param array $data An array of NCIC user data.
     *
     * @return bool Returns true if the NCIC user was successfully updated, false otherwise.
     */
    public function updateNCICUser($id, $data)
    {
        $stmt = $this->database->prepare(
            'UPDATE ncic_users
            SET first_name = :first_name,
            last_name = :last_name,
            created_at = :created_at
            WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':first_name', $data['first_name'], \PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], \PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $data['created_at'], \PDO::PARAM_STR);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Deletes an NCIC user from the database.
     *
     * @param int $id The ID of the NCIC user to be deleted.
     *
     * @return bool Returns true if the NCIC user was successfully deleted, false otherwise.
     */
    public function deleteNCICUser($id)
    {
        $stmt = $this->database->prepare('DELETE FROM ncic_users WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}
