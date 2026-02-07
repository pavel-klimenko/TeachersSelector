<?php

declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\WebSocket\Command;

use PersonalChatBundle\Infrastructure\WebSocket\ChatWebSocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'personal-chat:ws-server-start')]
class WebSocketServerCommand extends Command
{

    private ChatWebSocketServer $server;

    public function __construct(ChatWebSocketServer $server) {
        $this->server = $server;
        parent::__construct();
    }


    protected function configure():void
    {
        $this->setDescription('Starts the WebSocket server.');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->server->start();
        return Command::SUCCESS;
    }
}
