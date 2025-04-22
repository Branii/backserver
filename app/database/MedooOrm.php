<?php 
use Medoo\Medoo;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
class MedooOrm {

    private static $connection;

    protected static $DB_NAME_MAP = [1 => "eben_lottery_test" , 2 => "lottery_test"];
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

    public static function openLink($db_id=null) {
        // $db = $db_id == null ? $_ENV["DB_NAME"] : self::$DB_NAME_MAP[$db_id];
        // return self::$connection ?? self::getLink($db);
        $db = $db_id == null ? $_ENV["DB_NAME"] : self::$DB_NAME_MAP[$db_id];
        return self::getLink($db);
    }

     public static function getLink($db) {
       
            self::$connection = new Medoo([
                "type"     => $_ENV['DB_TYPE'],
                "host"     => $_ENV['DB_HOST'],
                "database" => $db,
                "username" => $_ENV['DB_USER'],
                "password" => $_ENV['DB_PASS'],
                "logging"  => true
            ]);
        return self::$connection;
    }

    public static function closeLink() {
        self::$connection = null; 
    }
}