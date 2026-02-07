<?php

namespace PersonalChatBundle\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DomainException;

use PersonalChatBundle\Domain\ValueObject\PersonalChatMessage\Message as MessageVO;

//Aggregate Root
class PersonalChat
{
    private ?int $id = null;

    private ChatParticipant $chatParticipantOne;
    private ChatParticipant $chatParticipantTwo;

    /** @var Collection<int, PersonalChatMessage> */
    private Collection $messages;

    public function __construct(ChatParticipant $one, ChatParticipant $two)
    {
        if ($one->getId() === $two->getId()) {
            throw new DomainException('participantOneOne and participantTwo must have different IDs');
        }

        $this->chatParticipantOne = $one;
        $this->chatParticipantTwo = $two;
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
       return $this->id;
    }

    public function getPartner(int $currentParticipantId): ChatParticipant
    {
        if ($this->chatParticipantOne->getId() === $currentParticipantId) {
            return $this->chatParticipantTwo;
        }

        return $this->chatParticipantOne;
    }


    public function getParticipants(): array
    {
        return [$this->chatParticipantOne, $this->chatParticipantTwo];
    }

    /** Добавление сообщения в чат */
    public function addMessage(ChatParticipant $author, MessageVO $message): PersonalChatMessage
    {
        if (!in_array($author, $this->getParticipants(), true)) {
            throw new \DomainException('Author must be a chat participant');
        }

        $message = new PersonalChatMessage($this, $author, $message);
        $this->messages->add($message);
        return $message;
    }

    /** @return Collection<int, PersonalChatMessage> */
    public function getMessages(): Collection
    {
        return $this->messages;
    }
}
