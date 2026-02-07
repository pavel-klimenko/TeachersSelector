<?php

namespace PersonalChatBundle\Application\Chats\PersonalChat\Command;

use PersonalChatBundle\Domain\Bus\Command\Command;


final class CreateChatCommand implements Command
{
    public function __construct(
        private readonly int $participantOneId,
        private readonly int $participantTwoId,
    ) {
    }

   public function getParticipantOne(): int
   {
       return $this->participantOneId;
   }

   public function getParticipantTwo(): int
   {
       return $this->participantTwoId;
   }

}
