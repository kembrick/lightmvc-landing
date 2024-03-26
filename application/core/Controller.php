<?php

namespace application\core;
abstract class Controller
{
    public array $route;
    public object $view;
    public object $model;

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['controller']);
    }

    private function loadModel(string $name) : ?object
    {
        $path = 'application\models\\' . ucfirst($name);
        if (class_exists($path))
            return new $path;
        else
            return NULL;
    }

}