<?php
require_once 'app/admin/controllers/AdminController.php';
require_once 'app/models/room_model.php';

class AdminRoomsController extends AdminController
{
    public function index()
    {
        $this->authenticate();
        
        // Если в URL передан id, значит мы редактируем
        $edit_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $edit_room = $edit_id ? RoomModel::find($edit_id) : null;

        $rooms = RoomModel::findAll();
        
        $data = [
            'rooms' => $rooms,
            'edit_room' => $edit_room // Передаем в вид для заполнения формы
        ];
        
        $this->view->render('admin_rooms_index.php', 'Управление номерами', $data, 'admin_layout.php');
    }
    
    public function save()
    {
        $this->authenticate();
        
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $room = $id ? RoomModel::find($id) : new RoomModel();
        
        $room->title = $_POST['title'];
        $room->description = $_POST['description'];
        $room->price = $_POST['price'];
        $room->capacity = $_POST['capacity'];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'public/assets/img/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('room_') . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
            $room->image = $filename;
        }
        
        $room->save();
        header('Location: /hotel/admin/rooms/index');
        exit;
    }
}