<?php

namespace Core;

class Page
{
    private $layout;
    private $title;
    private $view;
    private $data;

    /**
     * @param $layout
     * @param string $title
     * @param null $view
     * @param array $data
     */
    public function __construct($layout, string $title = '', $view = null, $data = [])
    {
        $this->layout = $layout;
        $this->title = $title;
        $this->view = $view;
        $this->data = $data;
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
