<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\PersonalChatMessagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: PersonalChatMessagesRepository::class)]
#[HasLifecycleCallbacks]
class PersonalChatMessages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?PersonalChat $personal_chat = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $related_user = null;

    #[ORM\Column(nullable: true)]
    private ?int $message_order = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonalChat(): ?PersonalChat
    {
        return $this->personal_chat;
    }

    public function setPersonalChat(?PersonalChat $personal_chat): static
    {
        $this->personal_chat = $personal_chat;
        return $this;
    }

    public function getRelatedUser(): ?User
    {
        return $this->related_user;
    }

    public function setRelatedUser(?User $related_user): static
    {
        $this->related_user = $related_user;
        return $this;
    }

    public function getMessageOrder(): ?int
    {
        return $this->message_order;
    }

    public function setMessageOrder(?int $message_order): static
    {
        $this->message_order = $message_order;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }
}
