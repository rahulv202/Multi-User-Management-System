<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($uri, $controller, $middleware = [])
    {
        $this->routes['GET'][$uri] = ['controller' => $controller, 'middleware' => $middleware];
    }

    public function post($uri, $controller, $middleware = [])
    {
        $this->routes['POST'][$uri] = ['controller' => $controller, 'middleware' => $middleware];
    }

    public function dispatch($uri, $method)
    {
        // Strip query parameters from the URI
        $uri = strtok($uri, '?');


        if (isset($this->routes[$method][$uri])) {
            $route = $this->routes[$method][$uri];
            //print_r($route);

            // Execute middleware
            $request = []; // Custom request array
            $next = function ($request) use ($route) {
                list($controller, $action) = explode('@', $route['controller']);
                $controllerClass = "App\\Controllers\\$controller";
                //echo $action;

                $controllerInstance = new $controllerClass();

                $controllerInstance->$action($request);
                return;
            };
            //print_r($route['middleware']);
            foreach ($route['middleware'] as $middlewareClassOrInstance) {
                // Determine if the middleware is an instance or a class name
                if (is_string($middlewareClassOrInstance)) {
                    // Instantiate if it's a class name (string)
                    $middlewareInstance = new $middlewareClassOrInstance();
                } else {
                    // Use as-is if it's already an instance
                    $middlewareInstance = $middlewareClassOrInstance;
                }

                // Chain the middleware
                $next = function ($request) use ($middlewareInstance, $next) {
                    return $middlewareInstance->handle($request, $next);
                };
            }


            return $next($request);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
