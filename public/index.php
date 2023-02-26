<?php

use Opencad\App\Routing\Router;

require_once(__DIR__ . "/../app/bootstrap.php");

// Create a new router
$router = new Router();

// Add routes to the router
$router->add('/', 'Home\HomeController');

// Run the router to handle the routing logic and controller execution
$router->run();
