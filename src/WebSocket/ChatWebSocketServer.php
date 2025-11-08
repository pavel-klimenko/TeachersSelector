<?php

namespace App\WebSocket;


use Predis\Client as RedisClient;
use Psr\Log\LoggerInterface;
use Swoole\WebSocket\Server;
use Swoole\Process;
use App\Infrastructure\Repository\UserRepository;
use Swoole\Coroutine\Redis;
use App\Infrastructure\Services\PersonalChatService;
use App\Infrastructure\Repository\PersonalChatMessagesRepository;
use App\Infrastructure\Repository\PersonalChatRepository;
use App\Domain\Entity\PersonalChatMessage;

class ChatWebSocketServer
{

    private UserRepository $userRepository;
    private PersonalChatRepository $personalChatRepository;
    private PersonalChatMessagesRepository $personalChatMessagesRepository;

    

    public function __construct(
        UserRepository $userRepository,
        PersonalChatRepository $personalChatRepository,
        PersonalChatMessagesRepository $personalChatMessagesRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->personalChatRepository = $personalChatRepository;
        $this->personalChatMessagesRepository = $personalChatMessagesRepository;
    }

    public function start()
    {
        $server = new Server("0.0.0.0", 8080);

        $server->on("start", function (Server $server) {
            echo "Swoole WebSocket Server started at ws://127.0.0.1:8080\n";
        });

        $server->on("open", function (Server $server, $request) {
            echo "Connection opened: {$request->fd}\n";
            //$server->push($request->fd, json_encode(["Welcome to Swoole WebSocket Server!"]));
        });

        $server->on("message", function (Server $server, $frame) {
            echo "Received message: {$frame->data}\n";

            $data = json_decode($frame->data, true);
            //$userId = $data['message_sender'] ?? null;


            //TODO sending WS data using API!!! Without including repo directly here

            //TODO devide WS message into channels, and check functionality with different users


            $personalChatService = new PersonalChatService();

            $currentUser = $this->userRepository->find($data['current_user_id']);

            if ($data['event'] == 'load_chat') {
                $arWSChat = $personalChatService->loadChat($data['chat_id'], $currentUser);
                $wsObject = json_encode($arWSChat);
            } else if ($data['event'] == 'add_message') {

                $messageSender = $currentUser;
                $chat = $this->personalChatRepository->find($data['chat_id']);

                $newMessage = new PersonalChatMessage();
                $newMessage->setPersonalChat($chat)
                ->setRelatedUser($messageSender)
                ->setMessage($data['message']);
                $this->personalChatMessagesRepository->save($newMessage);

                $arWSChat = $personalChatService->loadChat($data['chat_id'], $messageSender);
                $wsObject = json_encode($arWSChat);
            }

            $server->push($frame->fd, $wsObject);
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