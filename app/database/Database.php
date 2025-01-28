<?php 
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
class Database {
    private static $connection;
    public function __construct() {
       // self::$connection = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
        self::$connection = new PDO("mysql:host=192.168.1.51;dbname=lottery_test","enzerhub","enzerhub");
        // self::$connection = new PDO("mysql:host=localhost;dbname=lottery_test","enzerhub","enzerhub");
    }

    public static function openLink() {
        return self::$connection;
    }

    public static function closeLink() {
        self::$connection = null; 
    }
}