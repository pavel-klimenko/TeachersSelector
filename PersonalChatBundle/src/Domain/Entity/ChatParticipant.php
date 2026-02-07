<?php

namespace PersonalChatBundle\Domain\Entity;

class ChatParticipant
{
    private ?int $id = null;

    private ChatUserInterface $user;

    private string $name;

    public function __construct(ChatUserInterface $user, string $name)
    {
        $this->user = $user;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ChatUserInterface
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
