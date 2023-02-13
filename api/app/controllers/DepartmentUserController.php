<?php

namespace App\Controllers;

use Core\Response;
use App\Models\UserDepartmentModel;
use Exception;

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
                // If the result is true, send a success response with a message indicating that the user was added to the department.
                $response = Response::success(["message" => "User added to department"]);
                $response->send();
            } else {
                // If the result is false, throw an exception indicating that there was an error adding the user to the department.
                throw new Exception("Error adding user to department");
            }
        } catch (Exception $e) {
            // If an exception is thrown, send an error response with the message from the exception.
            $response = Response::error($e->getMessage());
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
                $response = Response::success(["message" => "User removed from department"]);
                $response->send();
            } else {
                // If the removal is not successful, throw an exception
                throw new Exception("Error removing user from department");
            }
        } catch (Exception $e) {
            // If an exception is thrown, return the error message to the client
            $response = Response::error($e->getMessage());
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
                // If no users were found in the department, throw an exception
                throw new Exception("No users found in department");
            }
        } catch (Exception $e) {
            // If an exception was thrown, create an error response with the exception message
            $response = Response::error($e->getMessage());
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
                // If no departments were found, throw an exception
                throw new Exception("User is not in any departments");
            }
        } catch (Exception $e) {
            // If an exception was thrown, return an error response with the exception message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }

}