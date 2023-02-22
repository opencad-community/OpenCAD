<?php

namespace App\Controllers\Api;

use App\Models\Api\ApiPermissions;
use Core\Request;
use Core\Response;
use Exception;

/**
 * The ApiPermissionController class is responsible for handling requests related to the ApiPermission model.
 */
class ApiPermissionController
{
    /**
     * An instance of the ApiPermission model to interact with the database.
     *
     * @var ApiPermissions
     */
    private $apiPermissionModel;

    /**
     * Constructor to instantiate an instance of the ApiPermission model.
     */
    public function __construct()
    {
        $this->apiPermissionModel = new ApiPermissions();
    }

    /**
     * The index method is used to retrieve all api permissions from the database.
     *
     * @return void
     */
    public function index()
    {
        try {
            // Get all api permissions from the database using the ApiPermission model
            $apiPermissions = $this->apiPermissionModel->getAllApiPermissions();
            if ($apiPermissions) {
                // If the api permissions were retrieved successfully,
                // send a success response with the api permissions data
                $response = Response::success($apiPermissions);
                $response->send();
            } else {
                // If no api permissions were found, send a not found response
                $response = Response::notFound("No api permissions found");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception was thrown, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Show the information of a specific api permission.
     *
     * @param int $id The ID of the api permission to retrieve.
     * @return void
     */
    public function show($id)
    {
        try {
            // Get api permission information by ID
            $apiPermission = $this->apiPermissionModel->getApiPermissionById($id);

            // If api permission is found, send a success response with the api permission data
            if ($apiPermission) {
                $response = Response::success($apiPermission);
                $response->send();
            } else {
                // If api permission is not found, send a not found response with a custom message
                $response = Response::notFound("Api permission with ID {$id} not found");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception is caught, send an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Creates a new API permission.
     *
     * @return void
     */
    public function create()
    {
        try {
            // Get the permission data from the input
            $data = Request::getData();

            // Pass the permission data to the addPermission method in the ApiPermission model
            $id = $this->apiPermissionModel->addPermission($data);

            // If the permission is successfully added,
            // send a success response with the message "API permission added with ID {$id}"
            if ($id) {
                $response = Response::success("API permission added with ID {$id}");
                $response->send();
            } else {
                // If there is an error, send an error response with the message "Error adding API permission"
                $response = Response::error("Error adding API permission");
                $response->send();
            }
        } catch (Exception $e) {
            // If there is an exception, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an existing API permission in the database.
     *
     * @param int $id The ID of the API permission to be updated.
     * @return void
     */
    public function update($id)
    {
        try {
            // Get the updated data from the input
            $data = Request::getData();

            // Call the updatePermission method from the ApiPermission model to update the API permission
            $result = $this->apiPermissionModel->updatePermission($id, $data);

            // If the update was successful, return a success response with a message
            if ($result) {
                $response = Response::success("API permission with ID {$id} updated");
                $response->send();
            } else {
                // If the update was not successful, return a not found response with an error message
                $response = Response::notFound("API permission with ID {$id} not found");
                $response->send();
            }
        } catch (Exception $e) {
            // If there is an exception, return an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Deletes an API permission from the database.
     *
     * @param int $id The ID of the API permission to delete.
     * @return void
     */
    public function delete($id)
    {
        try {
            // Try to delete the API permission from the database
            $result = $this->apiPermissionModel->deletePermission($id);

            // If the API permission was deleted successfully
            if ($result) {
                // Create a success response object with a message indicating that the API permission was deleted
                $response = Response::success("API permission with ID {$id} deleted");
                // Send the response to the client
                $response->send();
            } else {
                // If the API permission was not deleted,
                // create a not found response object with a message indicating that the API permission was not found
                $response = Response::notFound("API permission with ID {$id} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception was thrown, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }
}