<?php
// app/models/user_model.php

require_once 'app/core/BaseActiveRecord.php';

class UserModel extends BaseActiveRecord
{
    protected static $tablename = 'users';

    // Поля из таблицы users
    public $fio;
    public $email;
    public $login;
    public $password;

    /**
     * Поиск пользователя по логину (для проверки при входе или регистрации).
     */
    public static function findByLogin($login)
    {
        static::setupConnection();
        $sql = "SELECT * FROM " . static::$tablename . " WHERE login = :login";
        $stmt = static::$pdo->prepare($sql);
        $stmt->bindValue(":login", $login);
        $stmt->execute();
        
        $row = $stmt->fetch();
        if (!$row) return null;

        $obj = new static();
        foreach ($row as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }
}