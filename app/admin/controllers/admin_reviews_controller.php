<?php
require_once 'app/admin/controllers/AdminController.php';
require_once 'app/controllers/review_controller.php'; // Подключаем модель отзывов

class AdminReviewsController extends AdminController {
    public function index() {
        $this->authenticate();
        
        $reviews = ReviewModel::findAll(null, 0, 'is_approved ASC, created_at DESC');
        
        $data = ['reviews' => $reviews];
        $this->view->render('admin_reviews_index.php', 'Управление отзывами', $data, 'admin_layout.php');
    }

    public function approve() {
        $this->authenticate();
        $id = $_POST['id'] ?? 0;
        
        $review = ReviewModel::find($id);
        if ($review) {
            $review->is_approved = 1; // Одобряем!
            $review->save();
        }
        header('Location: /hotel/admin/reviews/index');
        exit;
    }

    public function delete() {
        $this->authenticate();
        $id = $_POST['id'] ?? 0;
        
        $review = ReviewModel::find($id);
        if ($review) {
            $review->delete();
        }
        header('Location: /hotel/admin/reviews/index');
        exit;
    }
}