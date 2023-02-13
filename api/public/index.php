<?php

use Core\Router;

require_once __DIR__ . "/../core/bootstrap.php";

// Create new Router instance
$router = new Router();
// Add routes to the router

// Route for the home page
$router->add('/', ['controller' => 'HomeController', 'action' => 'index']);

// Group of routes for the user
$router->group('/user', [], function () use ($router) {
    // Route for the user index page
    $router->add('', ['controller' => 'User\UserController', 'action' => 'index']);
    // Route for a specific user page
    $router->add('/([0-9]+)', ['controller' => 'User\UserController', 'action' => 'show']);
});

// Group of routes for departments
$router->group('/departments', [], function () use ($router) {
    // Route for the departments index page
    $router->add('', ['controller' => 'Departments\DepartmentController', 'action' => 'index']);
    // Route for creating a new department
    $router->add('/create', ['controller' => 'Departments\DepartmentController', 'action' => 'create']);
    // Route for viewing a specific department
    $router->add('/([0-9]+)', ['controller' => 'Departments\DepartmentController', 'action' => 'show']);
    // Route for editing a specific department
    $router->add('/([0-9]+)/edit', ['controller' => 'Departments\DepartmentController', 'action' => 'update']);
    // Route for deleting a specific department
    $router->add('/([0-9]+)/delete', ['controller' => 'Departments\DepartmentController', 'action' => 'delete']);
});

// Group of routes for user-department relationships
$router->group('/user/([0-9]+)/department/([0-9]+)/', [], function () use ($router) {
    // Route for adding a user to a department
    $router->add('add', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'addUserToDepartment']);
    // Route for removing a user from a department
    $router->add('remove', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'removeUserFromDepartment']);
});

// Group of routes for a specific department
$router->group('/department/([0-9]+)/', [], function () use ($router) {
    // Route for getting all users in a specific department
    $router->add('users', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'getUsersInDepartment']);
});

// Group of routes for a specific user
$router->group('/user/([0-9]+)/', [], function () use ($router) {
    // Route for getting all departments for a specific user
    $router->add('departments', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'getDepartmentsForUser']);
});



// Dispatch the URL
$router->dispatch($_SERVER['REQUEST_URI']);