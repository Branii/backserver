<?php
require '../vendor/autoload.php';
require_once("../autoload.php");
use ModernPHPException\ModernPHPException;

// Constants definition
define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("APP", ROOT . 'app' . DIRECTORY_SEPARATOR);
define("MODEL", APP . 'model' . DIRECTORY_SEPARATOR);
define("DATABASE", APP . 'database' . DIRECTORY_SEPARATOR);
define("CORE", APP . 'core' . DIRECTORY_SEPARATOR);
define("VIEWS", APP . 'views' . DIRECTORY_SEPARATOR);
define("CONTROLLER", APP . 'controller' . DIRECTORY_SEPARATOR);
define("UTILS", APP . 'utils' . DIRECTORY_SEPARATOR);
define('BASE_URL','/admin/app/'); 
$modules = [APP, MODEL, DATABASE, CORE, CONTROLLER,UTILS];
// Custom Autoloader Function
spl_autoload_register(function ($className) use ($modules) {
    foreach ($modules as $module) {
        $filePath = $module . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});

// (new ModernPHPException())->start();
(new App());
