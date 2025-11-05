<?php

namespace App\WebSocket;


use Predis\Client as RedisClient;
use Psr\Log\LoggerInterface;
use Swoole\WebSocket\Server;
use Swoole\Process;


use Swoole\Coroutine\Redis;

class ChatWebSocketServer
{
    //private $redis;

    public function __construct()
    {
        //$this->redis = new RedisClient();
    }

    public function start()
    {
        $server = new Server("0.0.0.0", 8080);

        $server->on("start", function (Server $server) {
            echo "Swoole WebSocket Server started at ws://127.0.0.1:8080\n";
        });

        $server->on("open", function (Server $server, $request) {
            echo "Connection opened: {$request->fd}\n";
            $server->push($request->fd, "Welcome to Swoole WebSocket Server!");
        });

        $server->on("message", function (Server $server, $frame) {
            echo "Received message: {$frame->data}\n";
            //TODO it is work, but need to reload a server!

            //TODO devide messages into channels and save to DATA BASE

            $server->push($frame->fd, json_encode(["hello", time()]));
        });

        $server->on("close", function (Server $server, $fd) {
            echo "Connection closed: {$fd}\n";
        });

        //TODO this is wrong

        // Creating a child redis subscription process
//        $process = new Process(function () use ($server) {
//            $redis = new RedisClient();
//            $redis->subscribe(['chat'], function ($redis, $channel, $message) use ($server) {
//                foreach ($server->connections as $fd) {
//                    $server->push($fd, $message);
//                }
//            });
//        });

        $server->start();
    }
}