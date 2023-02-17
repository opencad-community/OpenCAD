<?php

namespace App\Controllers\Departments;

use Core\Request;
use Core\Response;
use App\Models\Departments\Departments;

class DepartmentController
{
    private $department;

    public function __construct()
    {
        $this->department = new Departments();
    }

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
        } catch (\PDOException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

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
        } catch (\PDOException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

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
        } catch (\PDOException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

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
        } catch (\PDOException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }

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
        } catch (\PDOException $e) {
            $response = Response::internalServerError($e->getMessage());
            $response->send();
        }
    }
}