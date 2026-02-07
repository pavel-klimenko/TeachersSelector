<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Participant\Query;


use PersonalChatBundle\Domain\Bus\Query\QueryHandler;
use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;

final class GetParticipantByUserHandler implements QueryHandler
{
    public function __construct(
        private ChatParticipantRepositoryInterface $chatParticipiantRepository,
    ){}

    public function __invoke(GetParticipantByUserQuery $query): ChatParticipant
    {
        $userId = $query->getUserId();
        $participant = $this->chatParticipiantRepository->getParticipantByUserId($userId);

        if ($participant === null) {
            throw new DomainException(sprintf('Chat participant related with user ID %d not found', $userId));
        }
        return $participant;
    }
}
