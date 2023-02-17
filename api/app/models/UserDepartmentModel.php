<?php

namespace App\Models;

use Core\Database;

class UserDepartmentModel
{
    private $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

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

    public function removeUserFromDepartment($userId, $departmentId)
    {
        $stmt = $this->database->prepare("DELETE FROM user_departments WHERE user_id = :user_id AND department_id = :department_id");
        $stmt->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':department_id', $departmentId, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }

    public function getUsersInDepartment($departmentId)
    {
        $stmt = $this->database->prepare("SELECT users.* FROM users JOIN user_department ON users.id = user_department.user_id WHERE department_id = :department_id");
        $stmt->bindParam(':department_id', $departmentId, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);

        return $this->database->resultSet($stmt);
    }



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