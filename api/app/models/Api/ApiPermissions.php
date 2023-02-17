<?php

namespace App\Models\Api;

use Core\Database;
use PDO;

class ApiPermissions
{
    /**
     * The database connection.
     *
     * @var PDO
     */
    private $db;

    /**
     * Constructor to instantiate a database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all permissions.
     *
     * @return array|false
     */
    public function getAllApiPermissions()
    {
        $stmt = $this->db->prepare("SELECT * FROM api_permissions");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a permission by ID.
     *
     * @param int $id The ID of the permission.
     *
     * @return array|false
     */
    public function getApiPermissionById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM api_permissions WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Add a new permission.
     *
     * @param array $data The permission data.
     *
     * @return int|false The ID of the newly inserted permission, or false on failure.
     */
    public function addPermission($data)
    {
        $stmt = $this->db->prepare("INSERT INTO api_permissions (name) VALUES (:name)");
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Update an existing permission.
     *
     * @param int $id The ID of the permission.
     * @param array $data The new permission data.
     *
     * @return bool
     */
    public function updatePermission($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE api_permissions SET name = :name WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Delete a permission.
     *
     * @param int $id The ID of the permission.
     *
     * @return bool
     */
    public function deletePermission($id)
    {
        $stmt = $this->db->prepare("DELETE FROM api_permissions WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
