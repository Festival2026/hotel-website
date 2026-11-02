<?php
// app/core/BaseActiveRecord.php

class BaseActiveRecord
{
    public static $pdo = null;
    protected static $tablename;
    // Теперь это массив массивов: [ 'ИмяКласса' => [ 'поле1' => 'тип1', ... ] ]
    protected static $dbfields = []; 
    public $id;

    public function __construct()
    {
        if (!static::$tablename) {
            return;
        }
        static::setupConnection();
        static::getFields();
    }

    public static function setupConnection()
    {
        if (static::$pdo === null) {
            $dsn = 'mysql:dbname=hotel_db;host=127.0.0.1;charset=utf8mb4';
            $username = 'root';
            $password = '';
            
            try {
                static::$pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Ошибка подключения к БД: " . $e->getMessage());
            }
        }
    }

    public static function getFields()
    {
        $class = get_called_class(); // Получаем имя текущего класса (UserModel, StatisticModel и т.д.)
        
        if (!isset(static::$dbfields[$class]) || empty(static::$dbfields[$class])) {
            $stmt = static::$pdo->query("SHOW FIELDS FROM " . static::$tablename);
            static::$dbfields[$class] = [];
            while ($row = $stmt->fetch()) {
                static::$dbfields[$class][$row['Field']] = $row['Type'];
            }
        }
    }

    public function save()
    {
        $class = get_called_class();
        $fields = [];
        
        // Берем поля именно текущего класса!
        foreach (static::$dbfields[$class] as $field => $type) {
            if ($field !== 'id') {
                $fields[] = $field;
            }
        }

        if ($this->id) {
            $sets = [];
            foreach ($fields as $field) {
                $sets[] = "{$field} = :{$field}";
            }
            $sql = "UPDATE " . static::$tablename . " SET " . implode(', ', $sets) . " WHERE id = :id";
            
            $stmt = static::$pdo->prepare($sql);
            foreach ($fields as $field) {
                $stmt->bindValue(":{$field}", $this->$field);
            }
            $stmt->bindValue(":id", $this->id);
            $stmt->execute();

        } else {
            $placeholders = [];
            foreach ($fields as $field) {
                $placeholders[] = ":{$field}";
            }
            $sql = "INSERT INTO " . static::$tablename . " (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            
            $stmt = static::$pdo->prepare($sql);
            foreach ($fields as $field) {
                $stmt->bindValue(":{$field}", $this->$field);
            }
            $stmt->execute();
            
            $this->id = static::$pdo->lastInsertId();
        }

        return $this;
    }

    public function delete()
    {
        if (!$this->id) return false;
        $sql = "DELETE FROM " . static::$tablename . " WHERE id = :id";
        $stmt = static::$pdo->prepare($sql);
        $stmt->bindValue(":id", $this->id);
        return $stmt->execute();
    }

    public static function find($id)
    {
        static::setupConnection();
        $sql = "SELECT * FROM " . static::$tablename . " WHERE id = :id";
        $stmt = static::$pdo->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        
        $row = $stmt->fetch();
        if (!$row) return null;

        $obj = new static();
        foreach ($row as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }

    public static function countAll()
    {
        static::setupConnection();
        $stmt = static::$pdo->query("SELECT COUNT(*) FROM " . static::$tablename);
        return (int)$stmt->fetchColumn();
    }

    public static function findAll($limit = null, $offset = 0, $orderBy = 'id DESC')
    {
        static::setupConnection();
        
        $sql = "SELECT * FROM " . static::$tablename;
        if ($orderBy) {
            $sql .= " ORDER BY " . $orderBy;
        }
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        }

        $stmt = static::$pdo->query($sql);
        $rows = $stmt->fetchAll();

        $objects = [];
        foreach ($rows as $row) {
            $obj = new static();
            foreach ($row as $key => $value) {
                $obj->$key = $value;
            }
            $objects[] = $obj;
        }
        return $objects;
    }
}