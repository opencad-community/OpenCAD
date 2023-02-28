<?php

use Core\Router;

require_once __DIR__ . "/../core/bootstrap.php";

// Create new Router instance
$router = new Router();
// Add routes to the router

// Generate Token
// Endpoint: /api/generate-token
$router->add('/generate-token', ['controller' => 'Api\AuthController', 'action' => 'generateToken']);

// Route for the home page
// Endpoint: /api/
$router->add(
    '/',
    ['controller' => 'HomeController', 'action' => 'index'],
    []
);

// Group of routes for the user
// Endpoint: /api/user
$router->group(
    '/user',
    [],
    function () use ($router) {
        // Route for the user index page
        $router->add(
            '',
            ['controller' => USER_CONTROLLER, 'action' => 'index']
        );
        // Route for a specific user page
        // Endpoint: /api/user/{id}
        $router->add(
            '/' . REGEX_DIGITS,
            ['controller' => USER_CONTROLLER, 'action' => 'show']
        );
        // Route for creating a new user
        // Endpoint: /api/user/create
        $router->add(
            CREATE_ROUTE,
            ['controller' => USER_CONTROLLER, 'action' => 'create']
        );
        // Route for updating an existing user
        // Endpoint: /api/user/{id}/update
        $router->add(
            '/' . REGEX_DIGITS . UPDATE_ROUTE,
            ['controller' => USER_CONTROLLER, 'action' => 'update']
        );
        // Route for deleting an existing user
        // Endpoint: /api/user/{id}/delete
        $router->add(
            '/' . REGEX_DIGITS . DELETE_ROUTE,
            ['controller' => USER_CONTROLLER, 'action' => 'delete']
        );
        // Route for logging in user
        // Endpoint: /api/user/login
        $router->add(
            "/login",
            ["controller" => USER_CONTROLLER, "action" => "login"]
        );
    }
);

// Group of routes for departments
// Endpoint: /api/departments
$router->group('/departments', [], function () use ($router) {
    // Route for the departments index page
    $router->add(
        '',
        ['controller' => DEPARTMENT_CONTROLLER, 'action' => 'index']
    );
    // Route for creating a new department
    // Endpoint: /api/departments/create
    $router->add(
        CREATE_ROUTE,
        ['controller' => DEPARTMENT_CONTROLLER, 'action' => 'create']
    );
    // Route for viewing a specific department
    // Endpoint: /api/departments/{id}
    $router->add(
        '/' . REGEX_DIGITS,
        ['controller' => DEPARTMENT_CONTROLLER, 'action' => 'show']
    );
    // Route for editing a specific department
    // Endpoint: /api/departments/{id}/update
    $router->add(
        '/' . REGEX_DIGITS . UPDATE_ROUTE,
        ['controller' => DEPARTMENT_CONTROLLER, 'action' => 'update']
    );
    // Route for deleting a specific department
    // Endpoint: /api/departments/{id}/delete
    $router->add(
        '/' . REGEX_DIGITS . DELETE_ROUTE,
        ['controller' => DEPARTMENT_CONTROLLER, 'action' => 'delete']
    );
});

// Group of routes for user-department relationships
// Endpoint: /api/user/{id}/department/{id}/
$router->group(
    USER_ROUTE . REGEX_DIGITS . '/department/' . REGEX_DIGITS . '/',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for adding a user to a department
        // Endpoint: /api/user/{id}/department/{id}/add
        $router->add(
            'add',
            ['controller' => USER_DEPARTMENT_CONTROLLER, 'action' => 'addUserToDepartment']
        );
        // Route for removing a user from a department
        // Endpoint: /api/user/{id}/department/{id}/remove
        $router->add(
            'remove',
            ['controller' => USER_DEPARTMENT_CONTROLLER, 'action' => 'removeUserFromDepartment']
        );
    }
);

// Group of routes for a specific department
// Endpoint: /api/department/{id}/
$router->group(
    '/department/' . REGEX_DIGITS . '/',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for getting all users in a specific department
        // Endpoint: /api/department/{id}/users
        $router->add(
            'users',
            ['controller' => USER_DEPARTMENT_CONTROLLER, 'action' => 'getUsersInDepartment']
        );
    }
);

// Group of routes for a specific user
// Endpoint: /api/user/{id}/
$router->group(
    USER_ROUTE . REGEX_DIGITS . '/',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for getting all departments for a specific user
        // Endpoint: /api/user/{id}/departments
        $router->add(
            'departments',
            ['controller' => USER_DEPARTMENT_CONTROLLER, 'action' => 'getDepartmentsForUser']
        );
    }
);

// Group of routes for streets
// Endpoint: /api/streets/
$router->group(
    '/streets',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for getting all streets
        $router->add(
            '',
            ['controller' => GTAV_STREETS_CONTROLLER, 'action' => 'index']
        );
        // Route for getting a street by id
        // Endpoint: /api/streets/{id}
        $router->add(
            '/' . REGEX_DIGITS,
            ['controller' => GTAV_STREETS_CONTROLLER, 'action' => 'show']
        );
        // Route for adding a new street
        // Endpoint: /api/streets/create
        $router->add(
            CREATE_ROUTE,
            ['controller' => GTAV_STREETS_CONTROLLER, 'action' => 'create']
        );
        // Route for updating a street
        // Endpoint: /api/streets/update
        $router->add(
            '/' . REGEX_DIGITS . UPDATE_ROUTE,
            ['controller' => GTAV_STREETS_CONTROLLER, 'action' => 'update']
        );
        // Route for deleting a street
        // Endpoint: /api/streets/delete
        $router->add(
            '/' . REGEX_DIGITS . DELETE_ROUTE,
            ['controller' => GTAV_STREETS_CONTROLLER, 'action' => 'delete']
        );
    }
);

// Group of routes for the NCIC
// Endpoint: /api/ncic
$router->group(
    '/ncic',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for the NCIC index page
        $router->add(
            '',
            ['controller' => NCIC_CONTROLLER, 'action' => 'index']
        );
        // Route for a specific NCIC user page
        // Endpoint: /api/ncic/user/{id}
        $router->add(
            USER_ROUTE . REGEX_DIGITS,
            ['controller' => NCIC_CONTROLLER, 'action' => 'show']
        );
        // Route for creating a new NCIC user
        // Endpoint: /api/ncic/user/create
        $router->add(
            USER_ROUTE . CREATE_ROUTE,
            ['controller' => NCIC_CONTROLLER, 'action' => 'create']
        );
        // Route for updating an existing NCIC user
        // Endpoint: /api/ncic/user/{id}/update
        $router->add(
            USER_ROUTE . REGEX_DIGITS . UPDATE_ROUTE,
            ['controller' => NCIC_CONTROLLER, 'action' => 'update']
        );
        // Route for deleting an existing NCIC user
        // Endpoint: /api/ncic/user/{id}/delete
        $router->add(
            USER_ROUTE . REGEX_DIGITS . DELETE_ROUTE,
            ['controller' => NCIC_CONTROLLER, 'action' => 'delete']
        );

        // Route for all NCIC attributes
        // Endpoint: /api/ncic/attributes
        $router->add(
            '/attributes',
            ['controller' => NCIC_CONTROLLER, 'action' => 'showAttributes']
        );

        // Route for a specific NCIC attribute page
        // Endpoint: /api/ncic/attribute/{id}
        $router->add(
            '/' . ATTRIBUTE_ROUTE . '/' . REGEX_DIGITS,
            ['controller' => NCIC_CONTROLLER, 'action' => 'showUserAttributes']
        );

        // Route for creating a new NCIC attribute
        // Endpoint: /api/ncic/attribute/create
        $router->add(
            '/' . ATTRIBUTE_ROUTE . CREATE_ROUTE,
            ['controller' => NCIC_CONTROLLER, 'action' => 'createAttribute']
        );
        // Route for updating an existing NCIC attribute
        // Endpoint: /api/ncic/attribute/{id}/update
        $router->add(
            '/' . ATTRIBUTE_ROUTE . REGEX_DIGITS . UPDATE_ROUTE,
            ['controller' => NCIC_CONTROLLER, 'action' => 'updateAttribute']
        );
        // Route for deleting an existing NCIC attribute
        // Endpoint: /api/ncic/attribute/{id}/delete
        $router->add(
            '/' . ATTRIBUTE_ROUTE . REGEX_DIGITS . DELETE_ROUTE,
            ['controller' => NCIC_CONTROLLER, 'action' => 'deleteAttribute']
        );

        // Route for managing attributes for a specific NCIC user
        // Endpoint: /api/ncic/user/{id}/attributes
        $router->add(
            USER_ROUTE . REGEX_DIGITS . '/attributes',
            ['controller' => NCIC_CONTROLLER, 'action' => 'showUserAttributes']
        );

    }
);


// Group of routes for the API roles
// Endpoint: /api/api-role
$router->group('/api-role', ["AuthMiddleware"], function () use ($router) {
    // Route for the API roles index page
    $router->add(
        '',
        ['controller' => API_ROLE_CONTROLLER, 'action' => 'index']
    );
    // Route for viewing a specific API role
    // Endpoint: /api/api-role/{id}
    $router->add(
        '/' . REGEX_DIGITS,
        ['controller' => API_ROLE_CONTROLLER, 'action' => 'show']
    );
    // Route for creating a new API role
    // Endpoint: /api/api-role/create
    $router->add(
        CREATE_ROUTE,
        ['controller' => API_ROLE_CONTROLLER, 'action' => 'create']
    );
    // Route for updating a specific API role
    // Endpoint: /api/api-role/{id}/update
    $router->add(
        '/' . REGEX_DIGITS . UPDATE_ROUTE,
        ['controller' => API_ROLE_CONTROLLER, 'action' => 'update']
    );
    // Route for deleting a specific API role
    // Endpoint: /api/api-role/{id}/delete
    $router->add(
        '/' . REGEX_DIGITS . DELETE_ROUTE,
        ['controller' => API_ROLE_CONTROLLER, 'action' => 'delete']
    );
});

// Group of routes for the API Permissions
// Endpoint: /api/api-permissions
$router->group(
    '/api-permissions',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for the API Permissions index page
        $router->add(
            '',
            ['controller' => API_PERMISSION_CONTROLLER, 'action' => 'index']
        );
        // Route for viewing a specific API Permission
        // Endpoint: /api/api-permissions/{id}
        $router->add(
            '/' . REGEX_DIGITS,
            ['controller' => API_PERMISSION_CONTROLLER, 'action' => 'show']
        );
        // Route for creating a new API Permission
        // Endpoint: /api/api-permissions/create
        $router->add(
            CREATE_ROUTE,
            ['controller' => API_PERMISSION_CONTROLLER, 'action' => 'create']
        );
        // Route for editing a specific API Permission
        // Endpoint: /api/api-permissions/{id}/update
        $router->add(
            '/' . REGEX_DIGITS . UPDATE_ROUTE,
            ['controller' => API_PERMISSION_CONTROLLER, 'action' => 'update']
        );
        // Route for deleting a specific API Permission
        // Endpoint: /api/api-permissions/{id}/delete
        $router->add(
            '/' . REGEX_DIGITS . DELETE_ROUTE,
            ['controller' => API_PERMISSION_CONTROLLER, 'action' => 'delete']
        );
    }
);

// Group of routes for the API Role Permissions
// Endpoint: /api/api-role-permissions
$router->group(
    '/api-role-permissions',
    ["AuthMiddleware"],
    function () use ($router) {
        // Route for the api role permissions index page
        $router->add(
            '',
            ['controller' => API_ROLE_PERMISSIONS_CONTROLLER, 'action' => 'index']
        );
        // Route for viewing a specific api role permission
        // Endpoint: /api/api-role-permissions/{id}
        $router->add(
            '/' . REGEX_DIGITS,
            ['controller' => API_ROLE_PERMISSIONS_CONTROLLER, 'action' => 'show']
        );
        // Route for creating a new api role permission
        // Endpoint: /api/api-role-permissions/create
        $router->add(
            CREATE_ROUTE,
            ['controller' => API_ROLE_PERMISSIONS_CONTROLLER, 'action' => 'create']
        );
        // Route for editing a specific api role permission
        // Endpoint: /api/api-role-permissions/{id}/update
        $router->add(
            '/' . REGEX_DIGITS . UPDATE_ROUTE,
            ['controller' => API_ROLE_PERMISSIONS_CONTROLLER, 'action' => 'update']
        );
        // Route for deleting a specific api role permission
        // Endpoint: /api/api-role-permissions/{id}/perm/{id}/delete
        $router->add(
            '/role/' . REGEX_DIGITS . '/perm/' . REGEX_DIGITS . DELETE_ROUTE,
            ['controller' => API_ROLE_PERMISSIONS_CONTROLLER, 'action' => 'delete']
        );
    }
);

// Dispatch the URL
$router->dispatch($_SERVER['REQUEST_URI']);
