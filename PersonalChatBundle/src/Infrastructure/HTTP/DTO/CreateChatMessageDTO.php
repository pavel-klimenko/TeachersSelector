<?php

namespace PersonalChatBundle\Infrastructure\HTTP\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateChatMessageDTO
{
    #[Assert\Type(type: 'numeric')]
    #[Assert\Positive]
    public mixed $chatId;

    #[Assert\Length(min: 1)]
    public string $message;

    public function __construct(mixed $chatId, string $message)
    {
        $this->chatId = $chatId;
        $this->message = $message;
    }
}
