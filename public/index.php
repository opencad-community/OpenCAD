<?php

use Opencad\App\Routing\Router;

require_once(__DIR__ . "/../app/bootstrap.php");

// retrieve a translated string using the get method
echo $lang::get("welcome_message") . "<br>";

echo $lang::get("test_plugin_message");


// Create a new router
$router = new Router();

// Add routes to the router
$router->add('/', 'Home\HomeController');

// Run the router to handle the routing logic and controller execution
$router->run();
