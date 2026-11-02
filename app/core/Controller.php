<?php
// app/core/Controller.php — базовый класс для всех контроллеров

require_once 'app/models/statistic_model.php';

class Controller
{
    public $model;
    public $view;
    public $controller_name;
    public $action_name;

    public function __construct()
    {
        require_once 'app/core/View.php';
        $this->view = new View();
        
        $this->logStatistics(); // Вызываем сбор статистики
    }

    /**
     * Запись статистики о посетителе.
     */
    private function logStatistics()
    {
        // Не записываем статистику для админки, чтобы не засорять базу
        if (isset($_REQUEST['admin_area'])) {
            return; 
        }

        $stat = new StatisticModel();
        $stat->visit_time = date('Y-m-d H:i:s');
        $stat->web_page = $_SERVER['REQUEST_URI'] ?? 'Unknown';
        $stat->ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        
        // Получаем имя хоста по IP (может занять время, но по заданию нужно)
        $stat->host_name = gethostbyaddr($stat->ip_address) ?: 'Unknown';
        
        $stat->browser_name = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        
        $stat->save();
    }

    public function validate($data) {}
}