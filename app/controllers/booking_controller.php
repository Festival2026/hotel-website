<?php
// hotel/app/controllers/booking_controller.php

require_once 'app/core/Controller.php';
require_once 'app/models/room_model.php';
require_once 'app/models/booking_model.php';

class BookingController extends Controller
{
    public function index()
    {
        $rooms = RoomModel::findAll();
        
        // Если мы пришли из каталога (нажали кнопку "Забронировать" у конкретного номера)
        $selected_room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : null;

        $data = [
            'rooms' => $rooms,
            'selected_room_id' => $selected_room_id
        ];
        
        $this->view->render('booking.php', 'Бронирование номера', $data);
    }

    public function save()
    {
        // Проверяем, что форма отправлена
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /hotel/booking/index');
            exit;
        }

        // Получаем данные
        $room_id = (int)$_POST['room_id'];
        $fio = trim($_POST['fio']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];

        // Считаем количество дней
        $date1 = new DateTime($check_in);
        $date2 = new DateTime($check_out);
        $interval = $date1->diff($date2);
        $days = $interval->days;

        // Получаем данные номера для расчета цены (на сервере, чтобы пользователь не подделал цену)
        $room = RoomModel::find($room_id);
        $total_price = $room ? $room->price * $days : 0;

        // Сохраняем в БД
        $booking = new BookingModel();
        $booking->room_id = $room_id;
        $booking->fio = $fio;
        $booking->phone = $phone;
        $booking->email = $email;
		$booking->promo_code = trim($_POST['promo_code'] ?? '');
        $booking->check_in = $check_in;
        $booking->check_out = $check_out;
        $booking->total_price = $total_price;
        $booking->status = 'Новая';
        $booking->created_at = date('Y-m-d H:i:s');
        $booking->save();

        // Перенаправляем на главную с сообщением об успехе
        header('Location: /hotel/page/index?booking_success=1');
        exit;
    }
}