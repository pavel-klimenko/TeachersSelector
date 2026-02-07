<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Participant\Query;

use PersonalChatBundle\Domain\Bus\Query\Query;
use PersonalChatBundle\Domain\Entity\ChatParticipant;

final readonly class GetAvailableChatPartnersQuery implements Query
{
    public function __construct(private  ChatParticipant $chatParticipant)
    {}

   public function getChatParticipant(): ChatParticipant
   {
       return $this->chatParticipant;
   }
}
