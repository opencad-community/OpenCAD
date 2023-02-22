<?php

namespace App\Controllers\User;

use Exception;
use Core\Request;
use PDOException;
use Core\Response;
use App\Models\User\User;
use Opencad\App\Session\Session;
use App\Models\Relationships\UserDepartmentModel;
use Opencad\App\Helpers\Exceptions\Generic\UserDoesntExistException;
use Opencad\App\Helpers\Exceptions\Generic\InternalServerErrorException;

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

    private $userDepartmentModel;
    /**
     * Constructor to instantiate an instance of the User model.
     */
    public function __construct()
    {
        $this->userModel = new User();
        $this->userDepartmentModel = new UserDepartmentModel();

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
        } catch (InternalServerErrorException $e) {
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
            } else {
                // If user is not found, send a not found response with a custom message
                $response = Response::notFound("User with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
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
        } catch (InternalServerErrorException $e) {
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
        } catch (InternalServerErrorException $e) {
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
                // If the user was not deleted,
                // create a not found response object with a message indicating that the user was not found
                $response = Response::notFound("User with ID {$id} not found");
                // Send the response to the client
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception was thrown, create an internal server error response object with the exception message
            $response = Response::internalServerError($e->getMessage());
            // Send the response to the client
            $response->send();
        }
    }

    /**
     * Authenticates a user with email and password and starts a session.
     *
     * @return void
     */
    public function login()
    {
        try {
            // Get the data from the request
            $data = Request::getData();

            // Check if email and password are present in the body
            if (!isset($data["email"]) || !isset($data["password"])) {
                // If email and password are not present, return an error response
                $response = Response::error("Email and password required!");
                $response->send();
                exit();
            }

            // Set email and password
            $email = $data["email"];
            $password = $data["password"];

            try {
                // Verify the email and password using the User model
                $user = $this->userModel->verifyUser($email);
            } catch (UserDoesntExistException $e) {
                error_log("Error Occured: " . $e->getMessage());
            }

            // If the user is verified, send a success response with the user data
            if ($user) {
                // Check if the password matches
                if (!password_verify($password, $user[0]["password"])) {
                    // If the password doesn't match, return an error response
                    $response = Response::error("Password doesn't match");
                    $response->send();
                } else {
                    $departments = $this->userDepartmentModel->getDepartmentsForUser($user[0]["id"]);

                    // If the password matches, start a session with user data
                    $user = [
                        "id" => $user[0]["id"],
                        "name" => $user[0]["name"],
                        "username" => $user[0]["username"],
                        "email" => $user[0]["email"],
                        "departments" => [
                            "department_id" => $departments[0]["id"],
                            "department_name" => $departments[0]["name"],
                            "department_short_name" => $departments[0]["short_name"],
                            "department_active" => $departments[0]["active"]
                        ]
                    ];

                    Session::set("user", $user);
                    return;
                }
            } else {
                // If the user is not verified, return an unauthorized response
                $response = Response::unauthorized("Invalid email or password");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            // If an exception is caught, return an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }
}