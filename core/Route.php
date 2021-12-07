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
}
