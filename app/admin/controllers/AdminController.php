<?php
// app/admin/controllers/AdminController.php

require_once 'app/core/Controller.php';

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Запускаем сессию, если она еще не запущена
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Метод проверки авторизации администратора.
     * Если админ не авторизован — перекидываем его на страницу входа.
     */
        protected function authenticate()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Если переменной isAdmin нет или она не равна 1 — выкидываем на форму входа
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== 1) {
            header('Location: /hotel/authorization/index');
            exit;
        }
    }
}