<?php 
require 'vendor/autoload.php';
require 'app/services/Observer.php';
$loop = React\EventLoop\Factory::create();
$redisFactory = new Clue\React\Redis\Factory($loop);
$redisFactory->createClient('localhost:6379')->then(function ($redisClient) {
    // subscribe to the single channel
    // $redisClient->subscribe('deposit')->then(function () {
    //     echo "✅ Subscribed to Redis channel: channel \n";
    // });

    // subscribe to the multiple channels
    $channels = ['deposit', 'withdrawal', 'gamewon']; // Example channels
    foreach ($channels as $channel) { //Should return: ['channel1', 'channel2', ...]
        $redisClient->subscribe($channel)->then(function () use ($channel) {
            echo "✅ Subscribed to Redis channel: '$channel'\n";
        });
    }

    // Register message handler ONCE
    $redisClient->on('message', function ($channel, $message) {
         echo "🔔 Redis message on [$channel]:" . $message . '\n';
         $decoded = json_decode($message,true);
         $var =  Observer::observe($channel,$decoded);
         print_r($var);
    });
});

// Run the event loop
 $loop->run();

