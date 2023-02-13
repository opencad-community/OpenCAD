<?php

namespace App\Controllers;

use Core\Response;
use App\Models\Department;
use App\Models\UserDepartment;

class DepartmentController
{
    private $department;

    public function __construct()
    {
        $this->department = new Department();
    }

    public function index()
    {
        try {
            $departments = $this->department->getAllDepartments();
            if ($departments) {
                $response = Response::success($departments);
                $response->send();
            } else {
                $response = Response::error('No departments found');
                $response->send();
            }
        } catch (\PDOException $e) {
            $response = Response::error($e->getMessage());
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
                $response = Response::error("Department with ID {$id} not found");
                $response->send();
            }
        } catch (\PDOException $e) {
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }

    public function create()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $this->department->addDepartment($data);
            if ($id) {
                $response = Response::success(["message" => "Department added with ID {$id}"]);
                $response->send();
            } else {
                $response = Response::error('Error adding department');
                $response->send();
            }
        } catch (\PDOException $e) {
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }

    public function update($id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $this->department->updateDepartment($id, $data);
            if ($result) {
                $response = Response::success(["message" => "Department with ID {$id} updated"]);
                $response->send();
            } else {
                $response = Response::error("Error updating department with ID {$id}");
                $response->send();
            }
        } catch (\PDOException $e) {
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->department->deleteDepartment($id);
            if ($result) {
                $response = Response::success(["message" => "Department with ID {$id} deleted"]);
                $response->send();
            } else {
                $response = Response::error("Error deleting department with ID {$id}");
                $response->send();
            }
        } catch (\PDOException $e) {
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }
}