<?php

namespace PersonalChatBundle\Domain\Entity;

use PersonalChatBundle\Domain\ValueObject\PersonalChatMessage\Message as MessageVO;


class PersonalChatMessage
{
    private ?int $id = null;
    private PersonalChat $chat;
    private ChatParticipant $author;
    private string $message;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    public function __construct(PersonalChat $chat, ChatParticipant $author, MessageVO $message)
    {
        $this->chat = $chat;
        $this->author = $author;
        $this->message = $message->get();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
    public function getAuthor(): ChatParticipant { return $this->author; }
    public function getMessage(): MessageVO
    {
        return new MessageVO($this->message);
    }
}
