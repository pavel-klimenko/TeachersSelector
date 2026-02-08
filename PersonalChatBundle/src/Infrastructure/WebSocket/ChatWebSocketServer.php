<?php

declare(strict_types = 1);

namespace PersonalChatBundle\Infrastructure\WebSocket;

use Swoole\WebSocket\Server;
use Swoole\Process;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use PersonalChatBundle\Domain\Contracts\WsEncryptorInterface;

class ChatWebSocketServer
{
    private HttpClientInterface $httpClient;
    private ?string $authToken;
    private array $subscriptions = [];
    private array $sessions = [];

    private ?Server $server = null;


    public function __construct(
        #[Autowire('%env(string:WS_SIGN_SECRET)%')]
        private string $secretKey,
        #[Autowire('%env(string:CHAT_SERVER_HOST)%')]
        private string $serverHost,
        #[Autowire('%env(int:CHAT_WEB_SOCKET_PORT)%')]
        private int $webSocketPort,
        private WsEncryptorInterface $encryptor,
    )
    {

        $this->httpClient = HttpClient::create();
        $this->authToken = null;
    }

    public const HTTP_PROTOCOL = 'http';

    public function start()
    {
        $server = new Server('0.0.0.0', $this->webSocketPort);

        $server->on("start", function (Server $server) {
            echo "Swoole WebSocket Server started at ws://0.0.0.0:$this->webSocketPort \n";
        });

        $server->on("open", function (Server $server, $request) {
            echo "Connection opened: {$request->fd}\n";
            $server->push($request->fd, json_encode(["Welcome to Swoole WebSocket Server!"]));
        });

        $server->on("message", function (Server $server, $frame) {
            $data = json_decode($frame->data, true);


            // если пришёл auth_token — верифицируем и сохраняем sessionId для этого fd
            if (!empty($data['auth_token'])) {
                //save auth sessions for current client
                $phpSessionId = $this->encryptor->decrypt($this->secretKey, $data['auth_token']);

                if ($phpSessionId) {
                    $this->sessions[$frame->fd] = $phpSessionId;
                }
            }


            if ($data['event'] === ChatEvents::LOAD_CHAT->value) {
                //$this->authToken = $data['auth_token'];
                $chatId = (int)$data['chat_id'];
                $channel = 'personal_chat_' . $chatId;
                $this->subscriptions[$channel][$frame->fd] = true;
                $this->loadChat($server, $frame, $chatId);
            }

            if ($data['event'] == ChatEvents::ADD_MESSAGE->value) {
                $chatId = (int) $data['chat_id'];

                //$this->authToken = $data['auth_token'];
                $this->addMessage($frame, $chatId, $data['message']);

                $server->push($frame->fd, json_encode([
                    'event' => 'new_message',
                    'chat_id' => $chatId
                ]));

            }
        });

        $server->on("close", function (Server $server, $fd) {
            unset($this->sessions[$fd]);
            echo "Connection closed: {$fd}\n";
        });


        $server->start();
    }

    private function addMessage($frame, int $chatId, string $message):void
    {
        try {
            //$phpSessionId = $this->encryptor->decrypt($this->secretKey, $this->authToken);

            $phpSessionId = $this->sessions[$frame->fd];
            $url = self::HTTP_PROTOCOL.'://'.$this->serverHost.'/personal-chat/message';

            $this->httpClient->request('POST', $url, [
                'json' => ['chatId' => $chatId, 'message'=> $message],
                'headers' => [
                    'Accept' => 'application/json',
                    'Cookie' => 'PHPSESSID=' . $phpSessionId
                ],
            ]);

        } catch (\Throwable $e) {
            echo "Error sending message: {$e->getMessage()}\n";
        }
    }

    private function loadChat(Server $server, $frame, int $chatId):void
    {
        try {
            //$phpSessionId = $this->encryptor->decrypt($this->secretKey, $this->authToken);

            $phpSessionId = $this->sessions[$frame->fd];

            $url = self::HTTP_PROTOCOL.'://'.$this->serverHost.'/personal-chat/chat/' . $chatId;

            $response = $this->httpClient->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Cookie' => 'PHPSESSID=' . $phpSessionId
                ],
            ]);
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
