<?php

namespace App\Controllers\Relationships;

use Exception;
use Core\Request;
use Core\Response;
use App\Models\Relationships\ApiRolePermission;

class ApiRolePermissionController
{
    private $apiRolePermissionModel;

    public function __construct()
    {
        $this->apiRolePermissionModel = new ApiRolePermission();
    }

    public function index()
    {
        try {
            $apiRolePermissions = $this->apiRolePermissionModel->getAllApiRolePermissions();
            if ($apiRolePermissions) {
                $response = Response::success($apiRolePermissions);
                $response->send();
            } else {
                $response = Response::notFound("No api role permissions found");
                $response->send();
            }
        } catch (Exception $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Retrieve a single API role permission by ID
     *
     * @param int $id The ID of the API role permission to retrieve
     * @return void
     */
    public function show($id)
    {
        try {
            // Get the API role permission from the database by ID
            $apiRolePermission = $this->apiRolePermissionModel->getApiRolePermissionById($id);

            // If the API role permission was found, send a success response with the API role permission data
            if ($apiRolePermission) {
                $response = Response::success($apiRolePermission);
                $response->send();
            }
            // If the API role permission was not found, send a not found response with a custom message
            else {
                $response = Response::notFound("API role permission with ID {$id} not found");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception is caught, send an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


    public function create()
    {
        try {
            $data = Request::getData();

            $result = $this->apiRolePermissionModel->addApiRolePermissions($data);

            if ($result) {
                $response = Response::success("Api role permissions added");
                $response->send();
            } else {
                $response = Response::error("Error adding api role permissions");
                $response->send();
            }
        } catch (Exception $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    public function update($id)
    {
        try {
            $data = Request::getData();

            $result = $this->apiRolePermissionModel->updateApiRolePermissions($id, $data);

            if ($result) {
                $response = Response::success("Api role permissions updated");
                $response->send();
            } else {
                $response = Response::notFound("Api role permissions not found");
                $response->send();
            }
        } catch (Exception $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    public function delete($roleId, $permissionId)
    {
        try {
            $result = $this->apiRolePermissionModel->deleteApiRolePermissions($roleId, $permissionId);
            if ($result) {
                $response = Response::success("Api role permissions deleted");
                $response->send();
            } else {
                $response = Response::notFound("Api role permissions not found");
                $response->send();
            }
        } catch (Exception $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }
}