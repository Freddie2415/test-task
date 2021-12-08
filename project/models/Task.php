<?php

namespace Project\Models;

use Core\Model;
use Core\Route;

class Task extends Model
{
    private $id;
    private $name;
    private $email;
    private $description;
    private $status;
    private $edited;

    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $description
     * @param $status
     * @param bool $edited
     */
    public function __construct($id, $name, $email, $description, $status, bool $edited = false)
    {
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
        $this->status = $status;
        $this->id = $id;
        $this->edited = $edited;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getStatus(): bool
    {
        return (bool)$this->status;
    }

    public function getStatusText(): string
    {
        $statusText = (bool)$this->status === false ? 'Не выполнен' : 'Выполнен';

        if ($this->edited) {
            $statusText .= "|Отредактировано администратором";
        }

        return $statusText;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUrl(): string
    {
        return Route::generateUrl("tasks/$this->id/");
    }
}