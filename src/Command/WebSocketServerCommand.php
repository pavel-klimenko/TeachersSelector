<?php

namespace App\Command;

use App\WebSocket\ChatWebSocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'app:websocket-server')]
class WebSocketServerCommand extends Command
{
    protected static $defaultName = 'app:websocket-server';

    protected function configure():void
    {
        $this->setDescription('Starts the WebSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = new ChatWebSocketServer();
        $server->start();
        return Command::SUCCESS;
    }
}