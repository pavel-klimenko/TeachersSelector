<?php

namespace PersonalChatBundle\Application\Chats\Message\Command;

use PersonalChatBundle\Domain\Bus\Command\Command;


final class CreateChatMessageCommand implements Command
{
    public function __construct(
        private readonly int $chatId,
        private readonly int $participant,
        private readonly string $message,
    ) {
    }

   public function getParticipant(): int
   {
       return $this->participant;
   }

   public function getPersonalChat(): int
   {
       return $this->chatId;
   }

   public function getMessage(): string
   {
       return $this->message;
   }
}
