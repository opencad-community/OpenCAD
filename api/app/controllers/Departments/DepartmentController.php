<?php

namespace App\Controllers\Departments;

use Core\Request;
use Core\Response;
use App\Models\Departments\Departments;
use Opencad\App\Helpers\Exceptions\Generic\InternalServerErrorException;

/**
 * The DepartmentController class is responsible for handling HTTP requests related to the Departments model.
 * It provides methods for creating, updating, deleting, and retrieving departments from the database.
 */
class DepartmentController
{
    private $department;

    /**
     * Constructor for the DepartmentController class.
     * Creates a new Departments model instance.
     */
    public function __construct()
    {
        $this->department = new Departments();
    }

    /**
     * Retrieves all departments from the database.
     * Sends a successful response with the department data, or a not found response if no departments are found.
     * Sends an internal server error response if a database error occurs.
     */
    public function index()
    {
        try {
            $departments = $this->department->getAllDepartments();
            if ($departments) {
                $response = Response::success($departments);
                $response->send();
            } else {
                $response = Response::notFound('No departments found');
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Retrieves a department from the database by ID.
     * Sends a successful response with the department data, or a not found response if the department is not found.
     * Sends an internal server error response if a database error occurs.
     *
     * @param int $id The ID of the department to retrieve.
     */
    public function show($id)
    {
        try {
            $department = $this->department->getDepartmentById($id);
            if ($department) {
                $response = Response::success($department);
                $response->send();
            } else {
                $response = Response::notFound("Department with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Creates a new department in the database.
     * Sends a created response with a success message and the new department ID,
     * or a bad request response if an error occurs.
     * Sends an internal server error response if a database error occurs.
     */
    public function create()
    {
        try {
            $data = Request::getData();
            $id = $this->department->addDepartment($data);
            if ($id) {
                $response = Response::created(["message" => "Department added with ID {$id}"]);
                $response->send();
            } else {
                $response = Response::badRequest('Error adding department');
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Updates a department in the database by ID.
     * Sends a successful response with a success message, or a bad request response if an error occurs.
     * Sends an internal server error response if a database error occurs.
     *
     * @param int $id The ID of the department to update.
     */
    public function update($id)
    {
        try {
            $data = Request::getData();
            $result = $this->department->updateDepartment($id, $data);
            if ($result) {
                $response = Response::success(["message" => "Department with ID {$id} updated"]);
                $response->send();
            } else {
                $response = Response::badRequest("Error updating department with ID {$id}");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

    /**
     * Deletes a department from the database by ID.
     * Sends a successful response with a success message, or a not found response if the department is not found.
     * Sends an internal server error response if a database error occurs.
     *
     * @param int $id The ID of the department to delete.
     */
    public function delete($id)
    {
        try {
            $result = $this->department->deleteDepartment($id);
            if ($result) {
                $response = Response::success("Department with ID {$id} deleted");
                $response->send();
            } else {
                $response = Response::notFound("Department with ID {$id} not found");
                $response->send();
            }
        } catch (InternalServerErrorException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }
}
