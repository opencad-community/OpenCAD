<?php
namespace App\Models\Departments;

use Core\Database;

class Departments
{
    private $database;

    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    public function getAllDepartments()
    {
        $stmt = $this->database->prepare('SELECT * FROM departments');
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    public function getDepartmentById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    public function addDepartment($data)
    {
        $stmt = $this->database->prepare('INSERT INTO departments (name, short_name, dept_group, active) VALUES (:name, :short_name, :dept_group, :active)');
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':short_name', $data['short_name'], \PDO::PARAM_STR);
        $stmt->bindParam(':dept_group', $data['dept_group'], \PDO::PARAM_STR);
        $stmt->bindParam(':active', $data['active'], \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->lastInsertId();
    }

    public function updateDepartment($id, $data)
    {
        $stmt = $this->database->prepare('UPDATE departments SET name = :name, short_name = :short_name, dept_group = :dept_group, active = :active WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $data['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':short_name', $data['short_name'], \PDO::PARAM_STR);
        $stmt->bindParam(':dept_group', $data['dept_group'], \PDO::PARAM_STR);
        $stmt->bindParam(':active', $data['active'], \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }

    public function deleteDepartment($id)
    {
        $stmt = $this->database->prepare('DELETE FROM departments WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }
}