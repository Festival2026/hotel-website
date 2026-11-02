<?php
// hotel/app/admin/controllers/admin_pages_controller.php

require_once 'app/admin/controllers/AdminController.php';
require_once 'app/models/page_model.php';

class AdminPagesController extends AdminController
{
    /**
     * Список всех страниц.
     */
    public function index()
    {
        $this->authenticate();
        
        $pages = PageModel::findAll();
        
        $data = ['pages' => $pages];
        $this->view->render('admin_pages_index.php', 'Управление страницами', $data, 'admin_layout.php');
    }

    /**
     * Форма редактирования конкретной страницы.
     */
    public function edit()
    {
        $this->authenticate();
        
        // Получаем ID страницы из GET-параметра
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $page = PageModel::find($id);

        if (!$page) {
            die("Страница не найдена");
        }

        $data = ['page' => $page];
        $this->view->render('admin_pages_edit.php', 'Редактирование: ' . $page->title, $data, 'admin_layout.php');
    }

    /**
     * Сохранение изменений.
     */
    public function save()
    {
        $this->authenticate();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $page = PageModel::find($id);
            
            if ($page) {
                $page->title = $_POST['title'];
                $page->content = $_POST['content']; // Здесь уже будет HTML-код от CKEditor
                $page->save();
            }

            header('Location: /hotel/admin/pages/index');
            exit;
        }
    }
}