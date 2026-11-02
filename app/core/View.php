<?php
// app/core/View.php — базовый класс для отображения страниц

class View
{
    public function render($content_view, $title, $model = null, $layout = 'layout.php')
    {
        $controller_name = $GLOBALS['controller_name'] ?? 'page';
        $action_name     = $GLOBALS['action_name'] ?? 'index';

        // Определяем, в какой папке искать шаблоны (для админки или для юзера)
        $is_admin = isset($_REQUEST['admin_area']);
        $views_dir = $is_admin ? 'app/admin/views/' : 'app/views/';

        // Подключаем макет
        include $views_dir . $layout;
    }
}