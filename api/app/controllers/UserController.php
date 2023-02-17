<?php

namespace App\Controllers;

use Exception;
use Core\Response;
use App\Models\User;

/**
 * The UserController class is responsible for handling requests related to the User model.
 */
class UserController
{
    /**
     * An instance of the User model to interact with the database.
     *
     * @var User
     */
    private $userModel;

    /**
     * Constructor to instantiate an instance of the User model.
     */
    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * The index method is used to retrieve all users from the database.
     *
     * @return void
     */
    public function index()
    {
        try {
            // Get all users from the database using the User model
            $users = $this->userModel->getAllUsers();
            if ($users) {
                // If the users were retrieved successfully, send a success response with the users data
                $response = Response::success($users);
                $response->send();
            } else {
                // If no users were found, throw an exception
                throw new Exception("No users found");
            }
        } catch (Exception $e) {
            // If an exception was thrown, send an error response with the error message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }

    /**
     * Show the information of a specific user
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        try {
            // Get user information by ID
            $user = $this->userModel->getUserById($id);

            // If user is found, send a success response with the user data
            if ($user) {
                $response = Response::success($user);
                $response->send();
            }
            // If user is not found, throw an exception with an error message
            else {
                throw new Exception("User with ID {$id} not found");
            }
        } catch (Exception $e) {
            // If an exception is caught, send an error response with the exception message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }


    /**
     * Creates a new user
     *
     * This method creates a new user by getting the user data from the input and passing it to the addUser method
     * in the User model. If the user is successfully added, a success response is sent with the message "User added
     * with ID {$id}" where {$id} is the ID of the newly added user. If there is an error, an exception is thrown and
     * a response with the error message is sent.
     *
     * @return void
     */
    public function create()
    {
        try {
            // Get the user data from the input
            $data = json_decode(file_get_contents('php://input'), true);

            // Pass the user data to the addUser method in the User model
            $id = $this->userModel->addUser($data);

            // If the user is successfully added, send a success response with the message "User added with ID {$id}"
            if ($id) {
                $response = Response::success(["message" => "User added with ID {$id}"]);
                $response->send();
            } else {
                // If there is an error, throw an exception with the message "Error adding user"
                throw new Exception("Error adding user");
            }
        } catch (Exception $e) {
            // If there is an exception, send a response with the error message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }


    /**
     * Updates an existing user in the database
     *
     * @param int $id The ID of the user to be updated
     * @return void
     */
    public function update($id)
    {
        try {
            // Decode the incoming data from the request body
            $data = json_decode(file_get_contents('php://input'), true);

            // Call the updateUser method from the user model to update the user
            $result = $this->userModel->updateUser($id, $data);

            // If the update was successful, return a success response with a message
            if ($result) {
                $response = Response::success(["message" => "User with ID {$id} updated"]);
                $response->send();
            } else {
                // If the update was not successful, throw an exception with an error message
                throw new Exception("Error updating user with ID {$id}");
            }
        } catch (Exception $e) {
            // Catch any exceptions thrown and return an error response with the exception message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }


    /**
     * Deletes a user from the database
     *
     * @param int $id The id of the user to delete
     * @return void
     */
    public function delete($id)
    {
        try {
            // Try to delete the user from the database
            $result = $this->userModel->deleteUser($id);
            // If the user was deleted successfully
            if ($result) {
                // Create a success response object with a message indicating that the user was deleted
                $response = Response::success(["message" => "User with ID {$id} deleted"]);
                // Send the response to the client
                $response->send();
            } else {
                // If the user was not deleted, throw an exception with an error message
                throw new Exception("Error deleting user with ID {$id}");
            }
        } catch (Exception $e) {
            // If an exception was thrown, create an error response object with the exception message
            $response = Response::error($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

}