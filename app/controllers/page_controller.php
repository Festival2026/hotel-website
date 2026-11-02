<?php
// hotel/app/controllers/page_controller.php

require_once 'app/core/Controller.php';
require_once 'app/models/page_model.php';

class PageController extends Controller
{
    public function index()
    {
        $this->view->render('home.php', 'Главная');
    }

    // Универсальный метод для всех текстовых страниц
    public function viewPage()
    {
        // Получаем slug из URL (например, /hotel/page/about)
        $slug = $_GET['slug'] ?? 'about'; 
        
        $page = PageModel::findBySlug($slug);
        
        if (!$page) {
            die("Страница не найдена");
        }

        $data = ['page' => $page];
        
        // Используем один общий вид для всех страниц
        $this->view->render('page_view.php', $page->title, $data);
    }
	    // Страница Галереи
    public function gallery()
    {
        $this->view->render('gallery.php', 'Фото отеля');
    }
}
