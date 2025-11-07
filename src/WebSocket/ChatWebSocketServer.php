<?php

namespace App\WebSocket;


use Predis\Client as RedisClient;
use Psr\Log\LoggerInterface;
use Swoole\WebSocket\Server;
use Swoole\Process;
use App\Infrastructure\Repository\UserRepository;
use Swoole\Coroutine\Redis;
use App\Infrastructure\Services\PersonalChatService;
use App\Infrastructure\Repository\PersonalChatRepository;

class ChatWebSocketServer
{

    private UserRepository $userRepository;
    private PersonalChatRepository $personalChatRepository;

    public function __construct(
        UserRepository $userRepository,
        PersonalChatRepository $personalChatRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->personalChatRepository = $personalChatRepository;
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

            $data = json_decode($frame->data, true);
            //$userId = $data['message_sender'] ?? null;


            //TODO sending WS data using API!!! Without including repo directly here

            $personalChatService = new PersonalChatService();

            if ($data['event'] == 'load_chat') {
                $user = $this->userRepository->find($data['current_user_id']);
                $arWSChat = $personalChatService->loadChat($data['chat_id'], $user);
                $wsObject = json_encode($arWSChat);
            } else if ($data['event'] == 'add_message') {
                $chat = $this->personalChatRepository->find($data['chat_id']);

                $personalChatService->addMessageToChat($chat , $data['message_sender'],  $data['message']);
            } 

            //$server->push($frame->fd, $wsObject);
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