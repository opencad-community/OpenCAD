<?php

namespace App\Models\Relationships;

use Core\Database;

/**
 * ApiRolePermission model class that retrieves data from the api_role_permissions table.
 */
class ApiRolePermission
{
    /**
     * Instance of the database connection.
     *
     * @var Database
     */
    private $database;

    /**
     * Creates a new instance of the ApiRolePermission model.
     */
    public function __construct()
    {
        $this->database = Database::getInstance();
    }

    /**
     * Retrieves all api role permissions from the api_role_permissions table.
     *
     * @return array An array of api role permission objects.
     */
    public function getAllApiRolePermissions()
    {
        $stmt = $this->database->prepare(
            'SELECT rp.*, r.name AS role_name, p.name AS permission_name
        FROM api_role_permissions rp
        JOIN api_roles r ON rp.role_id = r.id
        JOIN api_permissions p ON rp.permission_id = p.id'
        );
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Retrieves a single api role permission from the api_role_permissions table by ID.
     *
     * @param int $id The ID of the api role permission to retrieve.
     *
     * @return array An array of api role permission objects.
     */
    public function getApiRolePermissionById($id)
    {
        $stmt = $this->database->prepare('SELECT * FROM api_role_permissions WHERE role_id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return $this->database->resultSet($stmt);
    }

    /**
     * Adds a new api role permission to the api_role_permissions table.
     *
     * @param array $data An array of api role permission data, including api_role_id and api_permission_id.
     *
     * @return int The ID of the newly inserted api role permission.
     */
    public function addApiRolePermissions($data)
    {
        $stmt = $this->database->prepare(
            'INSERT INTO api_role_permissions (api_role_id, api_permission_id)
            VALUES (:api_role_id, :api_permission_id)'
        );
        $stmt->bindParam(':api_role_id', $data['api_role_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':api_permission_id', $data['api_permission_id'], \PDO::PARAM_INT);
        $this->database->executeStatement($stmt);
        return (int) $this->database->lastInsertId();
    }

    /**
     * Updates an existing api role permission in the api_role_permissions table.
     *
     * @param int $id The ID of the api role permission to be updated.
     * @param array $data An array of api role permission data, including api_role_id and api_permission_id.
     *
     * @return bool Returns true if the api role permission was successfully updated, false otherwise.
     */
    public function updateApiRolePermissions($id, $data)
    {
        $stmt = $this->database->prepare(
            'UPDATE api_role_permissions
            SET api_role_id = :api_role_id, api_permission_id = :api_permission_id
            WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->bindParam(':api_role_id', $data['api_role_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':api_permission_id', $data['api_permission_id'], \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }

    /**
     * Deletes an api role permission from the api_role_permissions table.
     *
     * @param int $roleId The ID of the api role to remove permission from.
     * @param int $permissionId The ID of the permission to remove from the api role.
     *
     * @return bool Returns true if the api role permission was successfully deleted, false otherwise.
     */
    public function deleteApiRolePermissions($roleId, $permissionId)
    {
        $stmt = $this->database->prepare('DELETE api_role_permissions
        FROM api_role_permissions
        JOIN api_roles ON api_role_permissions.role_id = api_roles.id
        JOIN api_permissions ON api_role_permissions.permission_id = api_permissions.id
        WHERE api_roles.id = :role_id AND api_permissions.id = :permission_id');
        $stmt->bindParam(':role_id', $roleId, \PDO::PARAM_INT);
        $stmt->bindParam(':permission_id', $permissionId, \PDO::PARAM_INT);
        return $this->database->executeStatement($stmt);
    }

}