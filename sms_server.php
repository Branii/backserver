<?php
 require __DIR__ . '/vendor/autoload.php';

require_once 'app/model/SmsPreferenceScheduler.php';
$scheduler = new SmsPreferenceScheduler();
$scheduler->run();

