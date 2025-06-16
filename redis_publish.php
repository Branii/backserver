<?php
require 'vendor/autoload.php';
require 'app/model/MEDOOHelper.php';
$client->publish('deposit', json_encode($message));
$client = new Predis\Client();
$message =[
    'mobile' => "022445454",
    "message" => "Some message"
];
$client->publish('deposit', json_encode($message));


