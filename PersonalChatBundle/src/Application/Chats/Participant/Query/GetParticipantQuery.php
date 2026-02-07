<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Participant\Query;

use PersonalChatBundle\Domain\Bus\Query\Query;

final class GetParticipantQuery implements Query
{
    public function __construct(private int $participantId)
    {}

   public function getParticipantId(): int
   {
       return $this->participantId;
   }
}
