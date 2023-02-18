<?php

namespace Opencad\App\Routing;

use Exception;

class Router
{
  private $routes = array();

  // add() method to add routes to the router
  public function add($path, $controllerName)
  {
    $this->routes[$path] = $controllerName;
  }

  // run() method to match the current URL to a controller and call its execute() method
  public function run()
  {
    try {
      $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

      foreach ($this->routes as $path => $controllerName) {
        if ($url === $path) {
          $controllerClass = "Opencad\\Core\\Controllers\\" . $controllerName;

          if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            if (method_exists($controller, 'execute')) {
              $controller->execute();
              return;
            } else {
              throw new Exception("Controller method not found: execute()");
            }
          } else {
            throw new Exception("Controller class not found: $controllerClass");
          }
        }
      }

      http_response_code(404);
      echo '404 Page Not Found';
    } catch (Exception $e) {
      echo 'Error: ' . $e->getMessage();
    }

  }
}