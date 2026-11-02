<?php
// app/controllers/authorization_controller.php

require_once 'app/core/Controller.php';

class AuthorizationController extends Controller
{
    /**
     * Показ формы входа.
     */
    public function index()
    {
        $this->view->render('auth_login.php', 'Вход в Админ-панель');
    }

    /**
     * Обработка формы входа.
     */
    public function login()
    {
        // По методичке логин: admin@gmail.com
        // Пароль мы зашифруем через md5. Хеш 'qwerty' = d8578edf8458ce06fbc5bb76a58c5ca4
        if (isset($_POST['login']) && isset($_POST['password'])) {
            
            $login = $_POST['login'];
            $password_hash = md5($_POST['password']);

            if ($login === 'admin@gmail.com' && $password_hash === 'd8578edf8458ce06fbc5bb76a58c5ca4') {
                // Успешный вход
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['isAdmin'] = 1;
                
                // Перенаправляем в админку
                header('Location: /hotel/admin/bookings/index');
                exit;
            } else {
                // Ошибка входа
                $data = ['error' => 'Неверный логин или пароль!'];
                $this->view->render('auth_login.php', 'Вход в Админ-панель', $data);
                return;
            }
        }
        
        // Если пришли без POST-данных, просто показываем форму
        $this->index();
    }

    /**
     * Выход из системы.
     */
    public function log_out()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Уничтожаем сессию администратора
        unset($_SESSION['isAdmin']);
        
        // Перенаправляем на главную страницу сайта
        header('Location: /hotel/page/index');
        exit;
    }
}