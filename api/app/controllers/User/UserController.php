<?php

namespace App\Controllers\User;

use Exception;
use Core\Request;
use Core\Response;
use App\Models\User\User;

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
                // If no users were found, send a not found response
                $response = Response::notFound("No users found");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception was thrown, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
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
            // If user is not found, send a not found response with a custom message
            else {
                $response = Response::notFound("User with ID {$id} not found");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception is caught, send an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
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
            $data = Request::getData();
    
            // Pass the user data to the addUser method in the User model
            $id = $this->userModel->addUser($data);
    
            // If the user is successfully added, send a success response with the message "User added with ID {$id}"
            if ($id) {
                $response = Response::success("User added with ID {$id}");
                $response->send();
            } else {
                // If there is an error, send an error response with the message "Error adding user"
                $response = Response::error("Error adding user");
                $response->send();
            }
        } catch (Exception $e) {
            // If there is an exception, send an internal server error response with the error message
            $response = Response::internalServerError($e->getMessage());
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
            $data = Request::getData();
    
            // Call the updateUser method from the user model to update the user
            $result = $this->userModel->updateUser($id, $data);
    
            // If the update was successful, return a success response with a message
            if ($result) {
                $response = Response::success("User with ID {$id} updated");
                $response->send();
            } else {
                // If the update was not successful, return a not found response with an error message
                $response = Response::notFound("User with ID {$id} not found");
                $response->send();
            }
        } catch (\PDOException $e) {
            // Catch any exceptions thrown and return an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
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
                $response = Response::success("User with ID {$id} deleted");
                // Send the response to the client
                $response->send();
            } else {
                // If the user was not deleted, create a not found response object with a message indicating that the user was not found
                $response = Response::notFound("User with ID {$id} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (\Exception $e) {
            // If an exception was thrown, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }
    

}