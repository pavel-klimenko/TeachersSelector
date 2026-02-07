<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message;


final readonly class SendChatMessage
{
    public function __construct(
        public int $chatId,
        public int $authorId,
        public string $message,
    ) {}
}