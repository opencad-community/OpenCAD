<?php

namespace Core;

class Router
{
    // An array to store the routes
    protected $routes = [];

    /**
     * Add a route to the array of routes
     *
     * @param string $route The URL of the route
     * @param array $params An array of parameters for the route, including the controller and action
     *
     * @return void
     */
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
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
        // Remove any query string variables from the URL
        $url = $this->removeQueryStringVariables($url);

        // Try to match the URL to a route
        if ($params = $this->match($url)) {
            
            // Extract the controller, action, and parameters from the parameters for the route
            $controller = $params['controller'];
            $action = $params['action'];
            $params = $params['params'] ?? [];

            // Create an instance of the controller
            $controller = "App\Controllers\\$controller";
            $controller = new $controller();

            // Call the action on the controller, passing any dynamic parameters
            call_user_func_array([$controller, $action], $params);
        } else {
            // If no match is found, display an error message
            echo "No route found for URL: $url";
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
}