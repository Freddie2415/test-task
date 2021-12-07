<?php

namespace Core;

use Exception;

class Controller
{
    protected $layout = 'default';

    protected $title = '';

    public function __construct()
    {
        $this->startSessionIfNotStarted();
    }

    protected function render($view, $data = []): Page
    {
        return new Page($this->layout, $this->title, $view, $data);
    }

    protected function redirect(string $path = '/')
    {
        header("Location: $path", true, 301);
        exit();
    }

    /**
     * @throws Exception
     */
    protected function validate(array $attributeRules): array
    {
        $validData = [];
        $errorMessage = [];

        foreach ($attributeRules as $attribute => $rules) {
            foreach ($rules as $rule) {

                if ($rule === 'required') {
                    if (empty($_POST[$attribute])) {
                        $errorMessage[$attribute] = "*Заполните поле $attribute";
                    }
                }

                if ($rule === 'email') {
                    if (!filter_var($_POST[$attribute], FILTER_VALIDATE_EMAIL)) {
                        $errorMessage[$attribute] = "Невалидный формат email";
                    }
                }

                if ($rule === 'boolean') {

                    $_POST[$attribute] = isset($_POST[$attribute]) && $_POST[$attribute];

                    if (!is_bool($_POST[$attribute])) {
                        $errorMessage[$attribute] = "$attribute должен быть типа boolean";
                    }
                }

                if (!isset($errorMessage[$attribute])) {
                    $validData[$attribute] = $this->checkInput($_POST[$attribute]);
                }
            }
        }

        if (count($errorMessage) === 0) {
            return $validData;
        } else {

            foreach ($errorMessage as $key => $value) {
                $this->setFlashMessage($key . "Error", $value ?? null);
            }

            foreach ($validData as $key => $value) {
                $this->setFlashMessage($key, $value ?? null);
            }

            throw new Exception("Ошибка валидации");
        }
    }

    protected function sendErrorMessage(string $message)
    {
        $this->setFlashMessage('errorMessage', $message);
    }

    protected function sendSuccessMessage(string $message)
    {
        $this->setFlashMessage('successMessage', $message);
    }

    protected function hasUser(): bool
    {
        return isset($_SESSION['username']) && !empty($_SESSION['username']);
    }

    private function checkInput($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    private function startSessionIfNotStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function setFlashMessage(string $key, $message)
    {
        $_SESSION['FLASH_MESSAGE'][$key] = $message;
    }
}
