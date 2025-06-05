<?php 

spl_autoload_register(function ($class){
    $dirs = [
        'app','app/assets','app/controller','app/core',
        'app/database','app/model','app/views','app/services',
        'limvo','vendor'
    ];
    foreach ($dirs as $dir) {
        $filename = $dir . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($filename)) {
            include $filename;
            return;
        }
    }
});