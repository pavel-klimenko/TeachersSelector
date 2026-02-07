<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Participant\Query;

use DomainException;
use PersonalChatBundle\Domain\Bus\Query\QueryHandler;
use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;

final class GetParticipantHandler implements QueryHandler
{
    public function __construct(
        private ChatParticipantRepositoryInterface $chatParticipiantRepository,
    ){}

    public function __invoke(GetParticipantQuery $query): ChatParticipant
    {
        $participantId = $query->getParticipantId();
        $participant = $this->chatParticipiantRepository->getById($participantId);

        if ($participant === null) {
            throw new DomainException(sprintf('Chat participant with ID %d not found', $participantId));
        }

        return $participant;
    }
}
