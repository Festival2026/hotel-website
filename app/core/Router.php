<?php
// app/core/Router.php — маршрутизатор приложения

class Router
{
    public static function route()
    {
         // Получаем имя контроллера и действия
        $controller_name = isset($_REQUEST['controller']) && $_REQUEST['controller'] !== '' ? $_REQUEST['controller'] : 'page';
        $action_name = isset($_REQUEST['action']) && $_REQUEST['action'] !== '' ? $_REQUEST['action'] : 'index';

        
        $db_slugs = ['about', 'services', 'contacts', 'food', 'offers'];
        
        if ($controller_name === 'page' && in_array($action_name, $db_slugs)) {
            $_GET['slug'] = $action_name; // Передаем slug в GET
            $action_name = 'viewPage';    // Вызываем универсальный метод
        }

        // --- БЛОК ПРОВЕРКИ АДМИНКИ ---
        if (isset($_REQUEST['admin_area'])) {
            $admin_path = 'admin/';
            $admin_file_prefix = 'admin_';
            $admin_class_prefix = 'Admin';
        } else {
            $admin_path = '';
            $admin_file_prefix = '';
            $admin_class_prefix = '';
        }
        // -----------------------------

        // Формируем путь к файлу контроллера
        $controller_file = "app/{$admin_path}controllers/{$admin_file_prefix}{$controller_name}_controller.php";

        if (!file_exists($controller_file)) {
            die("ОШИБКА! Файл контроллера {$controller_file} не найден!");
        }

        $GLOBALS['controller_name'] = $controller_name;
        $GLOBALS['action_name'] = $action_name;

        require_once $controller_file;

        // Формируем имя класса контроллера (с учетом префикса)
        $controller_class_name = $admin_class_prefix . ucfirst($controller_name) . 'Controller';

        if (!class_exists($controller_class_name)) {
            die("ОШИБКА! Класс {$controller_class_name} не найден!");
        }

        $controller = new $controller_class_name();
        $controller->controller_name = $controller_name;
        $controller->action_name = $action_name;

        if (!method_exists($controller, $action_name)) {
            die("ОШИБКА! Метод {$action_name} не найден в контроллере {$controller_class_name}!");
        }

        $controller->$action_name();
    }
}