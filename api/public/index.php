<?php

use Core\Router;

require_once __DIR__ . "/../core/bootstrap.php";

// Create new Router instance
$router = new Router();
// Add routes to the router

// Generate Token
$router->add('/generate-token', ['controller' => 'Api\AuthController', 'action' => 'generateToken']);

// Route for the home page
$router->add('/', ['controller' => 'HomeController', 'action' => 'index'], ["AuthMiddleware"]);

// Group of routes for the user
$router->group('/user', [], function () use ($router) {
    // Route for the user index page
    $router->add('', ['controller' => 'User\UserController', 'action' => 'index']);
    // Route for a specific user page
    $router->add('/([0-9]+)', ['controller' => 'User\UserController', 'action' => 'show']);
    // Route for creating a new user
    $router->add('/create', ['controller' => 'User\UserController', 'action' => 'create']);
    // Route for updating an existing user
    $router->add('/([0-9]+)/update', ['controller' => 'User\UserController', 'action' => 'update']);
    // Route for deleting an existing user
    $router->add('/([0-9]+)/delete', ['controller' => 'User\UserController', 'action' => 'delete']);
    // Route for logging in user
    $router->add("/login", ["controller" => "User\UserController", "action" => "login"]);
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
$router->group('/user/([0-9]+)/department/([0-9]+)/', ["AuthMiddleware"], function () use ($router) {
    // Route for adding a user to a department
    $router->add('add', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'addUserToDepartment']);
    // Route for removing a user from a department
    $router->add('remove', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'removeUserFromDepartment']);
});

// Group of routes for a specific department
$router->group('/department/([0-9]+)/', ["AuthMiddleware"], function () use ($router) {
    // Route for getting all users in a specific department
    $router->add('users', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'getUsersInDepartment']);
});

// Group of routes for a specific user
$router->group('/user/([0-9]+)/', ["AuthMiddleware"], function () use ($router) {
    // Route for getting all departments for a specific user
    $router->add('departments', ['controller' => 'Relationships\DepartmentUserController', 'action' => 'getDepartmentsForUser']);
});

// Group of routes for streets
$router->group('/streets', ["AuthMiddleware"], function () use ($router) {
    // Route for getting all streets
    $router->add('', ['controller' => 'Game\GTAV\StreetsController', 'action' => 'index']);
    // Route for getting a street by id
    $router->add('/([0-9]+)', ['controller' => 'Game\GTAV\StreetsController', 'action' => 'show']);
    // Route for adding a new street
    $router->add('/create', ['controller' => 'Game\GTAV\StreetsController', 'action' => 'create']);
    // Route for updating a street
    $router->add('/([0-9]+)/update', ['controller' => 'Game\GTAV\StreetsController', 'action' => 'update']);
    // Route for deleting a street
    $router->add('/([0-9]+)/delete', ['controller' => 'Game\GTAV\StreetsController', 'action' => 'delete']);
});

// Group of routes for the NCIC
$router->group('/ncic', ["AuthMiddleware"], function () use ($router) {
    // Route for the NCIC index page
    $router->add('', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'index']);
    // Route for a specific NCIC user page
    $router->add('/user/([0-9]+)', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'show']);
    // Route for creating a new NCIC user
    $router->add('/user/create', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'create']);
    // Route for updating an existing NCIC user
    $router->add('/user/([0-9]+)/update', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'update']);
    // Route for deleting an existing NCIC user
    $router->add('/user/([0-9]+)/delete', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'delete']);

    // Route for all NCIC attributes
    $router->add('/attributes', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'showAttributes']);
    // Route for a specific NCIC attribute page
    $router->add('/attribute/([0-9]+)', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'showUserAttributes']);
    // Route for creating a new NCIC attribute
    $router->add('/attribute/create', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'createAttribute']);
    // Route for updating an existing NCIC attribute
    $router->add('/attribute/([0-9]+)/update', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'updateAttribute']);
    // Route for deleting an existing NCIC attribute
    $router->add('/attribute/([0-9]+)/delete', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'deleteAttribute']);

    // Route for managing attributes for a specific NCIC user
    $router->add('/user/([0-9]+)/attributes', ['controller' => 'Game\GTAV\NCIC\NCICController', 'action' => 'showUserAttributes']);

});


// Group of routes for the API roles
$router->group('/api-role', ["AuthMiddleware"], function () use ($router) {
    // Route for the API roles index page
    $router->add('', ['controller' => 'Api\ApiRoleController', 'action' => 'index']);
    // Route for creating a new API role
    $router->add('/create', ['controller' => 'Api\ApiRoleController', 'action' => 'create']);
    // Route for viewing a specific API role
    $router->add('/([0-9]+)', ['controller' => 'Api\ApiRoleController', 'action' => 'show']);
    // Route for updating a specific API role
    $router->add('/([0-9]+)/update', ['controller' => 'Api\ApiRoleController', 'action' => 'update']);
    // Route for deleting a specific API role
    $router->add('/([0-9]+)/delete', ['controller' => 'Api\ApiRoleController', 'action' => 'delete']);
});

// Group of routes for the API Permissions
$router->group('/api-permissions', ["AuthMiddleware"], function () use ($router) {
    // Route for the API Permissions index page
    $router->add('', ['controller' => 'Api\ApiPermissionController', 'action' => 'index']);
    // Route for creating a new API Permission
    $router->add('/create', ['controller' => 'Api\ApiPermissionController', 'action' => 'create']);
    // Route for viewing a specific API Permission
    $router->add('/([0-9]+)', ['controller' => 'Api\ApiPermissionController', 'action' => 'show']);
    // Route for editing a specific API Permission
    $router->add('/([0-9]+)/edit', ['controller' => 'Api\ApiPermissionController', 'action' => 'update']);
    // Route for deleting a specific API Permission
    $router->add('/([0-9]+)/delete', ['controller' => 'Api\ApiPermissionController', 'action' => 'delete']);
});

// Group of routes for the API Role Permissions
$router->group('/api-role-permissions', ["AuthMiddleware"], function () use ($router) {
    // Route for the api role permissions index page
    $router->add('', ['controller' => 'Relationships\ApiRolePermissionController', 'action' => 'index']);
    // Route for creating a new api role permission
    $router->add('/create', ['controller' => 'Relationships\ApiRolePermissionController', 'action' => 'create']);
    // Route for viewing a specific api role permission
    $router->add('/([0-9]+)', ['controller' => 'Relationships\ApiRolePermissionController', 'action' => 'show']);
    // Route for editing a specific api role permission
    $router->add('/([0-9]+)/edit', ['controller' => 'Relationships\ApiRolePermissionController', 'action' => 'update']);
    // Route for deleting a specific api role permission
    $router->add('/role/([0-9]+)/perm/([0-9])/delete', ['controller' => 'Relationships\ApiRolePermissionController', 'action' => 'delete']);
});

// Dispatch the URL
$router->dispatch($_SERVER['REQUEST_URI']);