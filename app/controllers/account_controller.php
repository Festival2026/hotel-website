<?php
// app/controllers/account_controller.php

require_once 'app/core/Controller.php';
require_once 'app/models/user_model.php';
require_once 'app/models/validators/form_validation.php';

class AccountController extends Controller
{
    // --- РЕГИСТРАЦИЯ ---
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new FormValidation();
            $validator->SetRule('fio', 'isNotEmpty');
            $validator->SetRule('email', 'isEmail');
            $validator->SetRule('login', 'isNotEmpty');
            $validator->SetRule('password', 'isNotEmpty');
            $validator->Validate($_POST);

            // Проверка на существующий логин
            $existingUser = UserModel::findByLogin($_POST['login']);
            if ($existingUser) {
                $validator->Errors['login'] = "Пользователь с таким логином уже существует.";
            }

            if ($validator->hasErrors()) {
                $data = ['validator' => $validator, 'post' => $_POST];
                $this->view->render('register.php', 'Регистрация', $data);
                return;
            }

            // Создаем пользователя (пароль хешируем через md5, как требуют в лабе)
            $user = new UserModel();
            $user->fio = $_POST['fio'];
            $user->email = $_POST['email'];
            $user->login = $_POST['login'];
            $user->password = md5($_POST['password']);
            $user->save();

            // Сразу авторизуем после регистрации
            if (session_status() === PHP_SESSION_NONE) session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_fio'] = $user->fio;

            header('Location: /mysite/page/index');
            exit;
        }

        $this->view->render('register.php', 'Регистрация');
    }

    // --- ВХОД ---
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = md5($_POST['password'] ?? '');

            $user = UserModel::findByLogin($login);

            if ($user && $user->password === $password) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_fio'] = $user->fio;

                // Если пришли из теста — вернем обратно на тест
                if (isset($_GET['redirect']) && $_GET['redirect'] === 'test') {
                    header('Location: /mysite/test/index');
                } else {
                    header('Location: /mysite/page/index');
                }
                exit;
            } else {
                $data = ['error' => 'Неверный логин или пароль!'];
                $this->view->render('login.php', 'Вход', $data);
                return;
            }
        }

        $this->view->render('login.php', 'Вход');
    }

    // --- ВЫХОД ---
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_fio']);
        
        header('Location: /mysite/page/index');
        exit;
    }
	    /**
     * AJAX-проверка занятости логина (Fetch + HTML).
     */
    public function checkLogin()
    {
        $login = $_POST['login'] ?? '';
        
        // Проверяем в БД
        $user = UserModel::findByLogin($login);
        
        // По заданию возвращаем HTML-фрагмент
        if ($user) {
            echo '<span style="color: red; font-weight: bold;">Занят</span>';
        } else {
            echo '<span style="color: green; font-weight: bold;">Свободен</span>';
        }
        exit; // Останавливаем дальнейшую загрузку страницы
    }
}