<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message;

Interface ChatMessageSenderInterface
{
    public function send(SendChatMessage $dto): void;
}
