<?php

namespace App\Controllers\Api;

use Core\Request;
use Core\Response;
use App\Models\Api\ApiRole;

/**
 * The ApiRoleController class is responsible for handling requests related to the ApiRole model.
 */
class ApiRoleController
{
    /**
     * An instance of the ApiRole model to interact with the database.
     *
     * @var ApiRole
     */
    private $apiRoleModel;

    /**
     * Constructor to instantiate an instance of the ApiRole model.
     */
    public function __construct()
    {
        $this->apiRoleModel = new ApiRole();
    }

    /**
     * The index method is used to retrieve all api roles from the database.
     *
     * @return void
     */
    public function index()
    {
        try {
            // Get all api roles from the database using the ApiRole model
            $apiRoles = $this->apiRoleModel->getAllApiRoles();
            if ($apiRoles) {
                // If the api roles were retrieved successfully, send a success response with the api roles data
                $response = Response::success($apiRoles);
                $response->send();
            } else {
                // If no api roles were found, send a not found response
                $response = Response::notFound("No api roles found");
                $response->send();
            }
        } catch (\PDOException $e) {
            // If an exception was thrown, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Show the information of a specific api role
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        try {
            // Get api role information by ID
            $apiRole = $this->apiRoleModel->getApiRoleById($id);

            // If api role is found, send a success response with the api role data
            if ($apiRole) {
                $response = Response::success($apiRole);
                $response->send();
            } else {
                // If api role is not found, send a not found response with a custom message
                $response = Response::notFound("Api role with ID {$id} not found");
                $response->send();
            }
        } catch (\PDOException $e) {
            // If an exception is caught, send an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Create a new API role
     *
     * This method creates a new API role by getting the role data from the input and passing it to the addRole method
     * in the ApiRole model. If the role is successfully added, success response is sent with the message "API role
     * added * with ID {$id}" where {$id} is the ID of the newly added role.
     * If there is an error, an exception is thrown and * a response with the error message is sent.
     *
     * @return void
     */
    public function create()
    {
        try {
            // Get the role data from the input
            $data = Request::getData();

            // Pass the role data to the addRole method in the ApiRole model
            $id = $this->apiRoleModel->addApiRole($data);

            // If the role is successfully added
            // send a success response with the message "API role added with ID {$id}"
            if ($id) {
                $response = Response::success("API role added with ID {$id}");
                $response->send();
            } else {
                // If there is an error, send an error response with the message "Error adding API role"
                $response = Response::error("Error adding API role");
                $response->send();
            }
        } catch (\PDOException $e) {
            // If there is an exception, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates an existing API role in the database
     *
     * @param int $id The ID of the API role to be updated
     * @return void
     */
    public function update($id)
    {
        try {
            // Get the API role data from the input
            $data = Request::getData();

            // Call the updateApiRole method in the API Role model to update the API role
            $result = $this->apiRoleModel->updateApiRole($id, $data);

            // If the update was successful, send a success response with a message
            if ($result) {
                $response = Response::success("API role with ID {$id} updated");
                $response->send();
            } else {
                // If the update was not successful, send a not found response with an error message
                $response = Response::notFound("API role with ID {$id} not found");
                $response->send();
            }
        } catch (\PDOException $e) {
            // Catch any exceptions thrown and send an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Deletes an API role from the database
     *
     * @param int $id The ID of the API role to be deleted
     * @return void
     */
    public function delete($id)
    {
        try {
            // Try to delete the API role from the database
            $result = $this->apiRoleModel->deleteApiRole($id);
            // If the API role was deleted successfully
            if ($result) {
                // Create a success response object with a message indicating that the API role was deleted
                $response = Response::success("API role with ID {$id} deleted");
                // Send the response to the client
                $response->send();
            } else {
                // If the API role was not deleted,
                // create a not found response object with a message indicating that the API role was not found
                $response = Response::notFound("API role with ID {$id} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (\PDOException $e) {
            // If an exception was thrown, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

}