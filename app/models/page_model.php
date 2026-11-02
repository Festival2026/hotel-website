<?php
require_once 'app/core/BaseActiveRecord.php';
class PageModel extends BaseActiveRecord {
    protected static $tablename = 'pages';
    public $slug;
    public $title;
    public $content;

    public static function findBySlug($slug) {
        static::setupConnection();
        $stmt = static::$pdo->prepare("SELECT * FROM pages WHERE slug = :slug");
        $stmt->bindValue(':slug', $slug);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row) return null;
        $obj = new static();
        foreach ($row as $key => $value) $obj->$key = $value;
        return $obj;
    }
}