<?php

namespace Project\Controllers;

use Core\Controller;
use Core\Page;
use Exception;

class AuthController extends Controller
{
    public function index(): ?Page
    {
        $this->title = 'Авторизация';

        if ($this->hasUser()) {
            $this->redirect();
        }

        return $this->render('auth/index');
    }


    public function login()
    {
        try {
            $validData = $this->validate([
                'login' => ['required'],
                'password' => ['required'],
            ]);

            if ($validData['login'] === 'admin' && $validData['password'] === '123') {
                $_SESSION['username'] = $validData['login'];

                $this->sendSuccessMessage('Вы успешно авторизовались');
            } else {
                throw new Exception('Неверный логин или пароль');
            }

            $this->redirect('/');
        } catch (Exception $e) {
            unset($_SESSION['password']);
            $this->sendErrorMessage($e->getMessage());
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        unset($_SESSION["username"]);
        $this->sendSuccessMessage('Вы успешно вышли из системы!');

        $this->redirect('/');

    }
}