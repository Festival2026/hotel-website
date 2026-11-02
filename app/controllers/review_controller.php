<?php
// hotel/app/controllers/review_controller.php

require_once 'app/core/Controller.php';
require_once 'app/core/BaseActiveRecord.php';

// Модель для отзывов
class ReviewModel extends BaseActiveRecord {
    protected static $tablename = 'reviews';
    public $user_id;
    public $author_name;
    public $text;
    public $rating;
    public $is_approved;
    public $created_at;
}

class ReviewController extends Controller
{
    public function index()
    {
        // Получаем только ОДОБРЕННЫЕ отзывы (is_approved = 1)
        ReviewModel::setupConnection();
        $stmt = ReviewModel::$pdo->query("SELECT * FROM reviews WHERE is_approved = 1 ORDER BY created_at DESC");
        $rows = $stmt->fetchAll();
        
        $reviews = [];
        foreach ($rows as $row) {
            $obj = new ReviewModel();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            $reviews[] = $obj;
        }

        // Проверяем, залогинен ли пользователь, чтобы подставить его имя в форму
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user_fio = $_SESSION['user_fio'] ?? '';

        $data = [
            'reviews' => $reviews,
            'user_fio' => $user_fio
        ];
        
        $this->view->render('reviews.php', 'Отзывы гостей', $data);
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review = new ReviewModel();
            $review->author_name = trim($_POST['author_name']);
            $review->text = trim($_POST['text']);
            $review->rating = (int)$_POST['rating'];
            $review->is_approved = 0; // По умолчанию на модерации!
            $review->created_at = date('Y-m-d H:i:s');
            $review->save();

            // После отправки возвращаем на страницу отзывов с сообщением
            header('Location: /hotel/review/index?sent=1');
            exit;
        }
    }
}