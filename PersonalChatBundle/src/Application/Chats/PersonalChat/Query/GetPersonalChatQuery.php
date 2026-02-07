<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\PersonalChat\Query;

use PersonalChatBundle\Domain\Bus\Query\Query;

final class GetPersonalChatQuery implements Query
{
    public function __construct(
        private int $chatId,
        private int $currentParticipantId
    )
    {}

   public function getChatId(): int
   {
       return $this->chatId;
   }

    public function getCurrentParticipant(): int
    {
        return $this->currentParticipantId;
    }
}