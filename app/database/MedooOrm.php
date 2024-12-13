<?php 
use Medoo\Medoo;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
class MedooOrm {

    private static $connection;
    public function __construct() {
        self::$connection = new Medoo([
            "type"=> $_ENV['DB_TYPE'],
            "host"=> $_ENV['DB_HOST'],
            "database"=> $_ENV['DB_NAME'],
            "username"=> $_ENV['DB_USER'],
            "password"=> $_ENV['DB_PASS'],
            "logging"=> true
        ]);
    }

    public static function openLink() {
        return self::$connection ?? self::getLink();
    }

     public static function getLink() {
        if (!self::$connection) {
            self::$connection = new Medoo([
                "type"     => $_ENV['DB_TYPE'],
                "host"     => $_ENV['DB_HOST'],
                "database" => $_ENV['DB_NAME'],
                "username" => $_ENV['DB_USER'],
                "password" => $_ENV['DB_PASS'],
                "logging"  => true
            ]);
        }
        return self::$connection;
    }

    public static function closeLink() {
        self::$connection = null; 
    }
}