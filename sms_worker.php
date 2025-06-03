<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'app/model/SmsPromotionWorker.php';
$worker = new SmsPromotionWorker();
$worker->run();