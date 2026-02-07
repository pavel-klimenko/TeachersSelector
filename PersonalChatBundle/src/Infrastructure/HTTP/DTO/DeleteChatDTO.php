<?php

namespace PersonalChatBundle\Infrastructure\HTTP\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class DeleteChatDTO
{
    #[Assert\Type(type: 'numeric')]
    #[Assert\Positive]
    public mixed $chatId;

    #[Assert\Type(type: 'numeric')]
    #[Assert\Positive]
    public mixed $participantWhoWantDelete;

    public function __construct(mixed $chatId, mixed $participantWhoWantDelete)
    {
        $this->chatId = $chatId;
        $this->participantWhoWantDelete = $participantWhoWantDelete;
    }
}
