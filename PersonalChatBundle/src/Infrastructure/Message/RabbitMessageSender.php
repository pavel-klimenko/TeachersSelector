<?php
declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\Message;

use Symfony\Component\Messenger\MessageBusInterface;
use PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message\ChatMessageSenderInterface;
use PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message\SendChatMessage;


final class RabbitMessageSender implements ChatMessageSenderInterface
{
    public function __construct(private MessageBusInterface $bus) {}

    public function send(SendChatMessage $dto): void
    {
        $this->bus->dispatch($dto);
    }
}
