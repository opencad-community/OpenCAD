<?php

namespace App\Controllers\Relationships;

use Exception;
use Core\Request;
use Core\Response;
use App\Models\Relationships\ApiRolePermission;
use Opencad\App\Helpers\Exceptions\Generic\InternalServerErrorException;

class ApiRolePermissionController
{
    private $apiRolePermissionModel;

    public function __construct()
    {
        $this->apiRolePermissionModel = new ApiRolePermission();
    }

    /**
     * Retrieves a list of all api role permissions
     *
     * @return void
     */
    public function index()
    {
        try {
            // Call the getAllApiRolePermissions() method of the ApiRolePermissionModel class
            // to retrieve all api role permissions
            $apiRolePermissions = $this->apiRolePermissionModel->getAllApiRolePermissions();

            if ($apiRolePermissions) {
                // If api role permissions were found, create a success response and send it to the client
                $response = Response::success($apiRolePermissions);
                $response->send();
            } else {
                // If no api role permissions were found, create a not found response and send it to the client
                $response = Response::notFound("No api role permissions found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception occurs, create an internal server error response and send it to the client
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
            } else {
                // If the API role permission was not found, send a not found response with a custom message
                $response = Response::notFound("API role permission with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception is caught, send an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


    /**
     * Creates a new api role permission
     *
     * @return void
     */
    public function create()
    {
        try {
            // Retrieve the data from the request body
            $data = Request::getData();

            // Call the addApiRolePermissions() method of the ApiRolePermissionModel class
            // to add the new api role permission
            $result = $this->apiRolePermissionModel->addApiRolePermissions($data);

            if ($result) {
                // If the new api role permission was added successfully,
                // create a success response and send it to the client
                $response = Response::success("Api role permissions added");
                $response->send();
            } else {
                // If an error occurred while adding the new api role permission,
                // create an error response and send it to the client
                $response = Response::error("Error adding api role permissions");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception occurs, create an internal server error response and send it to the client
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an api role permission
     *
     * @param int $id The ID of the api role permission to update
     * @return void
     */
    public function update($id)
    {
        try {
            // Retrieve the data from the request body
            $data = Request::getData();

            // Call the updateApiRolePermissions() method of the ApiRolePermissionModel class
            // to update the api role permission
            $result = $this->apiRolePermissionModel->updateApiRolePermissions($id, $data);

            if ($result) {
                // If the api role permission was updated successfully,
                // create a success response and send it to the client
                $response = Response::success("Api role permissions updated");
                $response->send();
            } else {
                // If the api role permission was not found, create a not found response and send it to the client
                $response = Response::notFound("Api role permissions not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception occurs, create an internal server error response and send it to the client
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


    /**
     * Deletes an api role permission
     *
     * @param int $roleId The ID of the role associated with the api role permission to delete
     * @param int $permissionId The ID of the permission associated with the api role permission to delete
     * @return void
     */
    public function delete($roleId, $permissionId)
    {
        try {
            // Call the deleteApiRolePermissions() method of the
            // ApiRolePermissionModel class to delete the api role permission
            $result = $this->apiRolePermissionModel->deleteApiRolePermissions($roleId, $permissionId);

            if ($result) {
                // If the api role permission was deleted successfully,
                // create a success response and send it to the client
                $response = Response::success("Api role permissions deleted");
                $response->send();
            } else {
                // If the api role permission was not found, create a not found response and send it to the client
                $response = Response::notFound("Api role permissions not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception occurs, create an internal server error response and send it to the client
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }
}
