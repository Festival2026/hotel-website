<?php
require_once 'app/admin/controllers/AdminController.php';
require_once 'app/core/BaseActiveRecord.php';
require_once 'app/models/booking_model.php';
require_once 'app/models/room_model.php';

class AdminBookingsController extends AdminController {
    public function index() {
        $this->authenticate();
        
        // Получаем все заявки, сортируем по дате создания (сначала новые)
        $bookings = BookingModel::findAll(null, 0, 'created_at DESC');
        
        // Чтобы вывести название номера, а не его ID, подтянем данные комнат
        $rooms = RoomModel::findAll();
        $roomsMap = [];
        foreach ($rooms as $r) {
            $roomsMap[$r->id] = $r->title;
        }

        $data = [
            'bookings' => $bookings,
            'roomsMap' => $roomsMap
        ];
        
        $this->view->render('admin_bookings_index.php', 'Заявки на бронь', $data, 'admin_layout.php');
    }

    public function updateStatus() {
        $this->authenticate();
        
        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? 'Новая';
        
        $booking = BookingModel::find($id);
        if ($booking) {
            $booking->status = $status;
            $booking->save();
        }
        
        header('Location: /hotel/admin/bookings/index');
        exit;
    }
}