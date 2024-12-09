<?php

namespace App\WebSocketServer;

class Client
{
    private string $channel;
    private $connection;

    public function __construct(string $channel, $con){
        $this->channel = $channel;
        $this->connection = $con;
    }

    public function send(string $message){
        $this->connection->send($message);
    }
    public function getChannel(): string
    {
        return $this->channel;
    }

}
