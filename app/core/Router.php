<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch($uri, $method)
    {
        if (isset($this->routes[$method][$uri])) {
            list($controller, $action) = explode('@', $this->routes[$method][$uri]);

            $controllerClass = "App\\Controllers\\$controller";
            $controllerInstance = new $controllerClass();
            $controllerInstance->$action();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
