<?php

namespace application\core;

class Router {

    protected array $routes = [];
    protected array $params = [];

    public function __construct()
    {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    private function add(string $route, array $params)
    {
        $route = preg_replace('/{([A-z0-9\-]+):([^}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    public function run()
    {
        if ($this->match()) {
            $path = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

    private function match() : bool
    {
        $url = trim(strtok($_SERVER["REQUEST_URI"],'?'), '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match))
                            $match = (int) $match;
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

}