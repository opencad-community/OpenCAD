<?php

require_once __DIR__ . "/../../vendor/autoload.php";
$config = require_once __DIR__ . "/../config/config.php";


// Constants for the routes.
define("USER_CONTROLLER", "User\UserController");
define("DEPARTMENT_CONTROLLER", "Departments\DepartmentController");
define("USER_DEPARTMENT_CONTROLLER", "Relationships\DepartmentUserController");
define("GTAV_STREETS_CONTROLLER", "Game\GTAV\StreetsController");
define("NCIC_CONTROLLER", "NCIC_CONTROLLER");
define("API_ROLE_CONTROLLER", "Api\ApiRoleController");
define("API_PERMISSION_CONTROLLER", "Api\ApiPermissionController");
define("API_ROLE_PERMISSIONS_CONTROLLER", "Relationships\ApiRolePermissionController");
define("REGEX_DIGITS", "([0-9]+)");
define("USER_ROUTE", "/user/");
define("ATTRIBUTE_ROUTE", "attribute");
define("CREATE_ROUTE", "/create");
define("UPDATE_ROUTE", "/update");
define("DELETE_ROUTE", "/delete");
