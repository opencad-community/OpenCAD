<?php

use Core\Router;

require_once __DIR__ . "/../core/bootstrap.php";

// Create new Router instance
$router = new Router();

// Add routes to the router
// Route for the home page
$router->add('/', ['controller' => 'HomeController', 'action' => 'index']);

// Routes for the user
$router->add('/user', ['controller' => 'UserController', 'action' => 'index']);
$router->add('/user/([0-9]+)', ['controller' => 'UserController', 'action' => 'show']);

// Routes for the department
$router->add('/departments', ['controller' => 'DepartmentController', 'action' => 'index']);
$router->add('/departments/create', ['controller' => 'DepartmentController', 'action' => 'create']);
$router->add('/departments/([0-9]+)', ['controller' => 'DepartmentController', 'action' => 'show']);
$router->add('/departments/([0-9]+)/edit', ['controller' => 'DepartmentController', 'action' => 'update']);
$router->add('/departments/([0-9]+)/delete', ['controller' => 'DepartmentController', 'action' => 'delete']);

// Routes for the user-department relationship
$router->add('/user/([0-9]+)/departments', ['controller' => 'DepartmentUserController', 'action' => 'getDepartmentsForUser']);
$router->add('/department/([0-9]+)/users', ['controller' => 'DepartmentUserController', 'action' => 'getUsersInDepartment']);
$router->add('/user/([0-9]+)/department/([0-9]+)/add', ['controller' => 'DepartmentUserController', 'action' => 'addUserToDepartment']);
$router->add('/user/([0-9]+)/department/([0-9]+)/remove', ['controller' => 'DepartmentUserController', 'action' => 'removeUserFromDepartment']);

// Dispatch the URL
$router->dispatch($_SERVER['REQUEST_URI']);
