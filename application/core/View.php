<?php

namespace application\core;

class View
{

    public string $path;
    public array $route;
    public string $layout = 'default';
    public string $content;
    public array $menu = [];
    public array $settings = [];

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render(array $vars = [])
    {
        extract($vars);
        $path = 'application/views/' . $this->path . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $this->content = ob_get_clean();
            require 'application/views/layouts/' . $this->layout . '.php';
        }
    }

    /**
     * Вывод страницы с кодом ошибки
     * @param int $code
     * @return void
     */
    public static function errorCode(int $code)
    {
        http_response_code($code);
        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path))
            require $path;
        exit;
    }

}
