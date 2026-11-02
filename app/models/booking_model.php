<?php
// hotel/app/models/booking_model.php
require_once 'app/core/BaseActiveRecord.php';

class BookingModel extends BaseActiveRecord
{
    protected static $tablename = 'bookings';
    public $room_id;
    public $fio;
    public $phone;
    public $email;
    public $check_in;
    public $check_out;
    public $total_price;
    public $status;
    public $created_at;
    public $promo_code;
}