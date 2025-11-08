<?php

namespace App\Command;

use App\Domain\Entity\User;
use App\WebSocket\ChatWebSocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Infrastructure\Repository\UserRepository;
use App\Infrastructure\Repository\PersonalChatRepository;
use App\Infrastructure\Repository\PersonalChatMessagesRepository;

#[AsCommand(name: 'app:websocket-server')]
class WebSocketServerCommand extends Command
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
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->personalChatRepository = $personalChatRepository;
        $this->personalChatMessagesRepository = $personalChatMessagesRepository;
    }


    protected static $defaultName = 'app:websocket-server';

    protected function configure():void
    {
        $this->setDescription('Starts the WebSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = new ChatWebSocketServer(
            $this->userRepository,
            $this->personalChatRepository,
            $this->personalChatMessagesRepository
        );
        $server->start();
        return Command::SUCCESS;
    }
}