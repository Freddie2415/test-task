<?php

namespace Core;

class Track
{
    private $controller;
    private $action;
    private $params;

    /**
     * @param $controller
     * @param $action
     * @param array $params
     */
    public function __construct($controller, $action, $params = [])
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
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
