<?php
// hotel/app/models/room_model.php
require_once 'app/core/BaseActiveRecord.php';

class RoomModel extends BaseActiveRecord
{
    protected static $tablename = 'rooms';
    public $title;
    public $description;
    public $price;
    public $image;
    public $capacity;
}