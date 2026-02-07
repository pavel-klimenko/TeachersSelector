<?php

declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Message\Factory;

use PersonalChatBundle\Domain\Entity\PersonalChat;
use PersonalChatBundle\Infrastructure\HTTP\DTO\ChatMessageResponseDTO;

class ChatMessagesFactory
{
    private array $messages = [];

    public function __construct(PersonalChat $personalChat)
    {
        foreach ($personalChat->getMessages() as $msg) {
            $this->messages[] = (new ChatMessageResponseDTO(
                $msg->getId(),
                $msg->getAuthor()->getId(),
                $msg->getMessage()->get(),
                $msg->getCreatedAt()->format('Y-m-d H:i:s')
            ))->toArray();
        }
    }

    public function toArray(): array
    {
        return $this->messages;
    }

}
