<?php
// use 
class Publisher  {

    private  $client;

    public function __construct(){
        $this->client = new Predis\Client();
    }

    public  function Publish(string $channel, array $message){
       $this->client->publish($channel, json_encode($message));
    }

}
