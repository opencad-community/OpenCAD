<?php

namespace App\Controllers\Relationships;

use Exception;
use Core\Response;
use App\Models\Relationships\UserDepartmentModel;

class DepartmentUserController
{
    private $userDepartmentModel;

    public function __construct()
    {
        $this->userDepartmentModel = new UserDepartmentModel();
    }

    /**
     * Adds a user to a department.
     *
     * @param int $departmentId The ID of the department to add the user to.
     * @param int $userId The ID of the user to add to the department.
     *
     * @throws Exception If there's an error adding the user to the department.
     *
     * @return void
     */
    public function addUserToDepartment($departmentId, $userId)
    {
        try {
            // Call the addUserToDepartment method from the UserDepartmentModel.
            $result = $this->userDepartmentModel->addUserToDepartment($departmentId, $userId);

            // Check if the result is true.
            if ($result) {
                // If the result is true,
                // send a success response with a message indicating that the user was added to the department.
                $response = Response::success("User added to department");
                $response->send();
            } else {
                // If the result is false,
                // send a not found response with a message indicating that the department or user could not be found.
                $response = Response::notFound("Department or user not found");
                $response->send();
            }
        } catch (\PDOException $e) {
            // If an exception is thrown, send an internal server error response with the message from the exception.
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


    /**
     * Removes a user from a department
     *
     * @param int $departmentId The ID of the department the user is to be removed from
     * @param int $userId The ID of the user to be removed from the department
     * @return void
     */
    public function removeUserFromDepartment($departmentId, $userId)
    {
        try {
            // Attempt to remove the user from the department
            $result = $this->userDepartmentModel->removeUserFromDepartment($departmentId, $userId);
            // If the removal is successful
            if ($result) {
                // Return success message to the client
                $response = Response::success("User removed from department");
                $response->send();
            } else {
                // If the removal is not successful, return a not found error to the client
                $response = Response::notFound("User not found in department");
                $response->send();
            }
        } catch (\PDOException $e) {
            // If an exception is thrown, return an internal server error to the client
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


    /**
     * Gets all the users in a department
     *
     * @param int $departmentId
     * @return void
     */
    public function getUsersInDepartment($departmentId)
    {
        try {
            // Get all users in the department
            $users = $this->userDepartmentModel->getUsersInDepartment($departmentId);
            // If users were found in the department
            if ($users) {
                // Create a success response with the users
                $response = Response::success($users);
                $response->send();
            } else {
                // If no users were found in the department
                $response = Response::notFound("No users found in department");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception was thrown, create an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }




    /**
     * Gets all the departments a user is in
     *
     * @param int $userId
     * @return void
     */
    public function getDepartmentsForUser($userId)
    {
        try {
            // Retrieve the departments for the user
            $departments = $this->userDepartmentModel->getDepartmentsForUser($userId);

            // If departments were found, return them in the response
            if ($departments) {
                $response = Response::success($departments);
                $response->send();
            } else {
                // If no departments were found, return a not found response
                $response = Response::notFound("User is not in any departments");
                $response->send();
            }
        } catch (Exception $e) {
            // If an exception was thrown, return an internal server error response with the exception message
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }


}