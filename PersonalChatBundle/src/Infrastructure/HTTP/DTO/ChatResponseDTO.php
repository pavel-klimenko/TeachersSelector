<?php

namespace PersonalChatBundle\Infrastructure\HTTP\DTO;

final readonly class ChatResponseDTO
{
    public int $chatId;

    public int $participantOneId;
    public int $participantTwoId;

    public function __construct(int $chatId, int $participantOneId, int $participantTwoId)
    {
        $this->chatId = $chatId;
        $this->participantOneId = $participantOneId;
        $this->participantTwoId = $participantTwoId;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->chatId,
            'participantOneId'  => $this->participantOneId,
            'participantTwoId'   => $this->participantTwoId,
        ];
    }
}
