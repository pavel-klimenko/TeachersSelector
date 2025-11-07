<?php

namespace App\Command;

use App\Domain\Entity\User;
use App\WebSocket\ChatWebSocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Infrastructure\Repository\UserRepository;

#[AsCommand(name: 'app:websocket-server')]
class WebSocketServerCommand extends Command
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }


    protected static $defaultName = 'app:websocket-server';

    protected function configure():void
    {
        $this->setDescription('Starts the WebSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = new ChatWebSocketServer($this->userRepository);
        $server->start();
        return Command::SUCCESS;
    }
}