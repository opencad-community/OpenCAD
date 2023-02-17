<?php
namespace App\Models\Departments;

use Core\Database;

class Departments
{
    /**
     * The database connection instance.
     *
     * @var Database
     */
    private $database;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Get all departments from the departments table.
     *
     * @return array
     */
    public function getAllDepartments()
    {
        try {
            $stmt = $this->database->prepare('SELECT * FROM departments');
            $this->database->executeStatement($stmt);
            $result = $this->database->resultSet($stmt);
            if ($result) {
                return $result;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log("Error getting all departments: " . $e->getMessage());
            return [];
        }
    }


    /**
     * Get a department from the departments table based on its ID.
     *
     * @param int $id
     * @return array
     */
    /**
     * Retrieves the department with the given ID.
     *
     * @param int $id The ID of the department.
     *
     * @return array An array of department data associated with the given ID.
     */
    public function getDepartmentById($id)
    {
        try {
            $stmt = $this->database->prepare('SELECT * FROM departments WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $this->database->executeStatement($stmt);
            $result = $this->database->resultSet($stmt);
            if ($result) {
                return $result;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            error_log("Error getting department by ID: " . $e->getMessage());
            return [];
        }
    }


    /**
     * Add a new department to the departments table.
     *
     * @param array $data
     * @return int
     */
    public function addDepartment($data)
    {
        try {
            $stmt = $this->database->prepare('INSERT INTO departments (name, short_name, dept_group, active) VALUES (:name, :short_name, :dept_group, :active)');
            $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
            $stmt->bindParam(':short_name', $data['short_name'], \PDO::PARAM_STR);
            $stmt->bindParam(':dept_group', $data['dept_group'], \PDO::PARAM_STR);
            $stmt->bindParam(':active', $data['active'], \PDO::PARAM_INT);
            $this->database->executeStatement($stmt);
            return (int) $this->database->lastInsertId();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Updates a department in the database.
     *
     * @param int $id The ID of the department to update.
     * @param array $data An array of data to update the department with.
     *
     * @return bool True if the department was successfully updated, False otherwise.
     */
    public function updateDepartment($id, $data)
    {
        try {
            $stmt = $this->database->prepare('UPDATE departments SET name = :name, short_name = :short_name, dept_group = :dept_group, active = :active WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
            $stmt->bindParam(':short_name', $data['short_name'], \PDO::PARAM_STR);
            $stmt->bindParam(':dept_group', $data['dept_group'], \PDO::PARAM_STR);
            $stmt->bindParam(':active', $data['active'], \PDO::PARAM_INT);
            $this->database->executeStatement($stmt);
            return true;
        } catch (\PDOException $e) {
            // Log the error message to the console
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a department from the departments table.
     * 
     * @param int $id The ID of the department to be deleted.
     * 
     * @return bool Returns true if the department was successfully deleted, false otherwise.
     */
    public function deleteDepartment($id)
    {
        try {
            $stmt = $this->database->prepare('DELETE FROM departments WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            return $this->database->executeStatement($stmt);
        } catch (\PDOException $e) {
            // Log the error message to the console
            error_log($e->getMessage());
            return false;
        }
    }

}