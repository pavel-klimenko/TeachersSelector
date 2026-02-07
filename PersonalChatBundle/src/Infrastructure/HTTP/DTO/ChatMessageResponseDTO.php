<?php

namespace PersonalChatBundle\Infrastructure\HTTP\DTO;

final readonly class ChatMessageResponseDTO
{
    public function __construct(
        public int $id,
        public int $authorId,
        public string $message,
        public string $createdAt
    ) {}

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'authorId'  => $this->authorId,
            'message'   => $this->message,
            'createdAt' => $this->createdAt,
        ];
    }
}

