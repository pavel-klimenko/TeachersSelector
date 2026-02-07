<?php

declare(strict_types = 1);

namespace PersonalChatBundle\Infrastructure\WebSocket;

use Swoole\WebSocket\Server;
use Swoole\Process;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatWebSocketServer
{
    private HttpClientInterface $httpClient;

    public function __construct(
        #[Autowire('%env(string:CHAT_SERVER_HOST)%')]
        private string $serverHost,

        #[Autowire('%env(int:CHAT_WEB_SOCKET_PORT)%')]
        private int $webSocketPort,
    )
    {
        $this->httpClient = HttpClient::create();
    }

    public const HTTP_PROTOCOL = 'http';

    public function start()
    {
        $server = new Server('0.0.0.0', $this->webSocketPort);

        $server->on("start", function (Server $server) {
            echo "Swoole WebSocket Server started\n";
        });

        $server->on("open", function (Server $server, $request) {
            echo "Connection opened: {$request->fd}\n";
            $server->push($request->fd, json_encode(["Welcome to Swoole WebSocket Server!"]));
        });

        $server->on("message", function (Server $server, $frame) {
            $data = json_decode($frame->data, true);

            if ($data['event'] === 'load_chat') {
                $this->loadChat($server, $frame, (int)$data['chat_id']);
            }


            if ($data['event'] == 'add_message') {
                $chatId = (int) $data['chat_id'];
                $participantId = (int) $data['participant_id'];
                $message = $data['message'];
                $this->addMessage($chatId, $participantId, $message);

                $server->push($frame->fd, json_encode([
                    'event' => 'new_message',
                    'chat_id' => $chatId
                ]));

            }
        });

        $server->on("close", function (Server $server, $fd) {
            echo "Connection closed: {$fd}\n";
        });

        $server->start();
    }

    private function addMessage(int $chatId, int $participantId, string $message):void
    {
        $url = self::HTTP_PROTOCOL.'://'.$this->serverHost.'/personal-chat/message';

        $this->httpClient->request('POST', $url, [
            'json' => [
                'participantId' => $participantId,
                'chatId'        => $chatId,
                'message'       => $message,
            ],
        ]);
    }

    private function loadChat(Server $server, $frame, int $chatId):void
    {
        try {
            $url = self::HTTP_PROTOCOL.'://'.$this->serverHost.'/personal-chat/chat/' . $chatId;

            $response = $this->httpClient->request('GET', $url);
            $content = $response->getContent(false);

            $messages = json_decode($content, true)['messages'] ?? [];
            $server->push($frame->fd, json_encode([
                'event' => 'chat_loaded',
                'chat_id' => $chatId,
                'messages' => $messages
            ]));

        } catch (\Throwable $e) {
            echo "Error loading chat: {$e->getMessage()}\n";
        }
    }
}
