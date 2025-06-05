<?php
ini_set("display_errors",1);
require __DIR__ . '/vendor/autoload.php';
require 'app/services/GearmanWorker.php'; 
require 'app/services/Testworkers.php'; 
require 'app/services/SmsWoker.php'; 
$worker = new SmsWoker();
$worker->run();
