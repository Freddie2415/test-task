<?php

namespace Core;

class Route
{
    private $path;
    private $controller;
    private $action;
    private $method;

    /**
     * @param $path
     * @param $controller
     * @param $action
     * @param $method
     */
    public function __construct($path, $controller, $action, $method)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    static function generateUrl(string $path): string
    {
        if (!empty($path) && $path[0] === '/') {
            $path = substr($path, 1);
        }

        return APP_URL . "/$path";
    }
}
