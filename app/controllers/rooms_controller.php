<?php
// hotel/app/controllers/rooms_controller.php

require_once 'app/core/Controller.php';
require_once 'app/models/room_model.php';

class RoomsController extends Controller
{
    public function index()
    {
        // Получаем все номера из БД
        $rooms = RoomModel::findAll(null, 0, 'price ASC');
        
        $data = [
            'rooms' => $rooms
        ];
        
        $this->view->render('rooms.php', 'Наши номера', $data);
    }
	    /**
     * Страница подробного просмотра номера.
     */
    public function view()
    {
        // Получаем ID номера из URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $room = RoomModel::find($id);
        
        if (!$room) {
            die("Номер не найден");
        }

        $data = ['room' => $room];
        
        $this->view->render('room_detail.php', $room->title, $data);
    }
}