<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Participant\Query;

use PersonalChatBundle\Domain\Bus\Query\Query;

final class GetParticipantByUserQuery implements Query
{
    public function __construct(private int $userId)
    {}

   public function getUserId(): int
   {
       return $this->userId;
   }
}
