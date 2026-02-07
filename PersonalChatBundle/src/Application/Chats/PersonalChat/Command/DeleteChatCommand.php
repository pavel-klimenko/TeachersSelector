<?php

namespace PersonalChatBundle\Application\Chats\PersonalChat\Command;

use PersonalChatBundle\Domain\Bus\Command\Command;


final readonly class DeleteChatCommand implements Command
{
    public function __construct(
        private int $chatId,
        private int $participantWhoWantDelete,
    ) {
    }

   public function getChat(): int
   {
       return $this->chatId;
   }

   public function getParticipantWhoWantDelete(): int
   {
       return $this->participantWhoWantDelete;
   }

}
