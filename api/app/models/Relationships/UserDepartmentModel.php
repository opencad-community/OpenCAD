<?php

namespace App\Models\Relationships;

use Core\Database;
use Core\Response;

/**
 * Class UserDepartmentModel
 *
 * The UserDepartmentModel class provides functionality for managing user to department relationships.
 * It uses the database class to interact with the database and perform database operations.
 */
class UserDepartmentModel
{
    /**
     * @var \Core\Database $database An instance of the database class.
     */
    private $database;

    /**
     * UserDepartmentModel constructor.
     *
     * Instantiates the database class to use for database operations.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }


    /**
     * Adds a user to a department.
     *
     * @param int $userId The ID of the user to add to the department.
     * @param int $departmentId The ID of the department to add the user to.
     *
     * @return bool True if the user was added to the department, False otherwise.
     */
    public function addUserToDepartment($userId, $departmentId)
    {
        try {
            $stmt = $this->database->prepare('INSERT INTO user_department (user_id, department_id) VALUES (:user_id, :department_id)');
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $stmt->bindParam(':department_id', $departmentId, \PDO::PARAM_INT);
            $this->database->executeStatement($stmt);
            return true;
        } catch (\PDOException $e) {
            // Log the error message to the console
            error_log($e->getMessage());
            return false;
        }
    }

   /**
 * Removes a user from a department.
 *
 * @param int $userId The ID of the user to remove from the department.
 * @param int $departmentId The ID of the department to remove the user from.
 *
 * @return bool True if the user was removed from the department, False otherwise.
 */
public function removeUserFromDepartment($userId, $departmentId)
{
    try {
        $stmt = $this->database->prepare("DELETE FROM user_departments WHERE user_id = :user_id AND department_id = :department_id");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':department_id', $departmentId, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return true;
    } catch (\PDOException $e) {
        // Log the error message to the console
        error_log($e->getMessage());
        return false;
    }
}


    /**
     * Retrieves all users associated with the given department.
     *
     * @param int $departmentId The ID of the department.
     *
     * @return array An array of user objects associated with the given department.
     */
    public function getUsersInDepartment($departmentId)
    {
        try {
            $stmt = $this->database->prepare("SELECT users.* FROM users JOIN user_department ON users.id = user_department.user_id WHERE department_id = :department_id");
            $stmt->bindParam(':department_id', $departmentId, \PDO::PARAM_INT);
            $this->database->executeStatement($stmt);
            $result = $this->database->resultSet($stmt);
            if ($result) {
                return $result;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log("Error getting users in department: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Retrieves all departments associated with the given user.
     *
     * @param int $userId The ID of the user.
     *
     * @return array An array of department objects associated with the given user.
     */
    public function getDepartmentsForUser($userId)
    {
        try {
            $stmt = $this->database->prepare('SELECT departments.* FROM departments JOIN user_department ON departments.id = user_department.department_id WHERE user_department.user_id = :user_id');
            $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $this->database->executeStatement($stmt);
            $result = $this->database->resultSet($stmt);
            if ($result) {
                return $result;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log("Error getting departments for user: " . $e->getMessage());
            return [];
        }
    }
}