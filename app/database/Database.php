<?php 
class Database {
    private static $connection;
    // public function __construct() {
    //     self::$connection = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    // }

    public static function openLink() {
        self::$connection = new PDO('mysql:host=localhost;dbname=lottery_test', 'enzerhub', 'enzerhub');
        return self::$connection;
    }

    public static function closeLink() {
        self::$connection = null; 
    }
}