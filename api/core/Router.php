<?php

namespace Core;

use Exception;

class Router
{
    // An array to store the routes
    protected $routes = [];
    // An array to store the middlewares
    protected $middlewares = [];
    // A property to store the base URL for the current group
    private $baseUrl = '';


    /**
     * Add a route to the array of routes
     *
     * @param string $route The URL of the route
     * @param array $params An array of parameters for the route, including the controller and action
     * @param array $middlewares An array of middlewares for the route (optional)
     *
     * @throws Exception If an error occurs while adding the route
     *
     * @return void
     */
    public function add($route, $params, $middlewares = [])
    {
        try {
            // Concatenate the base URL and the route
            $route = $this->baseUrl . $route;
            $route = '/api' . $route;

            // Merge the route-specific middlewares with the global middlewares
            $params['middlewares'] = array_merge($this->middlewares, $middlewares);

            // Add the route and its parameters to the array of routes
            $this->routes[$route] = $params;
        } catch (Exception $e) {
            // Log the error message
            error_log("Error adding route: " . $e->getMessage());

            // Return an error response
            $response = Response::error("Error adding route: " . $e->getMessage());
            $response->send();
        }
    }



    /**
     * Add a middleware to the array of middlewares
     *
     * @param string $middleware The class name of the middleware
     *
     * @return void
     */
    public function use ($middleware)
    {
        try {
            $this->middlewares[] = $middleware;

        } catch (Exception $e) {
            // If an error occurs, log the error message
            error_log($e->getMessage());
        }

    }

    /**
     * Match a URL to a route in the array of routes
     *
     * @param string $url The URL to match
     *
     * @return array|bool The parameters for the route if a match is found, or false if no match is found
     */
    public function match ($url)
    {
        try {
            // Loop through each route in the array of routes
            foreach ($this->routes as $route => $params) {
                // Check if the URL matches the route, taking into account any dynamic parameters
                if (preg_match("#^$route$#", $url, $matches)) {
                    // Remove the first match, which is the entire URL
                    array_shift($matches);

                    // Add the dynamic parameters to the parameters for the route
                    $params['params'] = $matches;
                    // Return the parameters for the route
                    return $params;
                }
            }

            // If no match is found, return false
            return false;
        } catch (Exception $e) {
            // If an error occurs, log the error message
            error_log($e->getMessage());

            // Return false to indicate that no match was found
            return false;
        }
    }

    /**
     * Dispatch a URL to the appropriate controller and action
     *
     * @param string $url The URL to dispatch
     *
     * @return void
     */
    public function dispatch($url)
    {
        try {
            // Remove any query string variables from the URL
            $url = $this->removeQueryStringVariables($url);

            if ($params = $this->match($url)) {
                $controller = $params['controller'];
                $action = $params['action'];
                $routeParams = $params['params'] ?? [];
                $middlewares = $params['middlewares'] ?? [];
                $namespace = $params['namespace'] ?? 'App\Controllers\\';

                // Loop through each middleware in the array of middlewares
                foreach ($middlewares as $middleware) {
                    $middleware = "App\Middlewares\\$middleware";
                    // Create an instance of the middleware
                    $middleware = new $middleware();

                    // Call the handle method on the middleware
                    $middleware->handle();
                }

                // Create an instance of the controller
                $controller = "$namespace$controller";
                $controller = new $controller();

                // Call the action on the controller, passing any dynamic parameters
                call_user_func_array([$controller, $action], $routeParams);
            } else {
                // If no match is found, add a default route
                $controller = "App\Controllers\Error\NotFoundController";
                $controller = new $controller();
                $controller->index();
            }
        } catch (Exception $e) {
            // If an exception is caught, send an error response with the exception message
            $response = Response::error($e->getMessage());
            $response->send();
        }
    }



    /**
     * Remove any query string variables from a URL
     *
     * @param string $url The URL to remove query string variables from
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        // If there are any question marks in the URL
        if (strpos($url, '?') !== false) {
            // Split the URL into two parts, separating the query string variables
            $parts = explode('?', $url);

            // Use the first part of the URL as the URL without query string variables
            $url = $parts[0];
        }

        // Return the URL without the query string variables
        return $url;
    }

    /**
     * Get the array of middlewares
     *
     * @return array The array of middlewares
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * Group together routes with a common prefix and middlewares
     *
     * @param string $prefix The common prefix for the routes in the group
     * @param array $middlewares The middlewares to be applied to the routes in the group
     * @param callable $closure The closure containing the routes in the group
     *
     * @return void
     */
    public function group($prefix, $middlewares, $closure)
    {
        // Store the current base URL
        $previousBaseUrl = $this->baseUrl;
        // Append the prefix to the current base URL
        $this->baseUrl .= $prefix;

        // Store the current middlewares
        $previousMiddlewares = $this->middlewares;
        // Merge the new middlewares with the current middlewares
        $this->middlewares = array_merge($this->middlewares, $middlewares);

        // Call the closure containing the routes in the group
        call_user_func($closure);

        // Reset the base URL to its previous value
        $this->baseUrl = $previousBaseUrl;
        // Reset the middlewares to their previous value
        $this->middlewares = $previousMiddlewares;
    }

}