<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Participant\Query;


use PersonalChatBundle\Domain\Bus\Query\QueryHandler;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;

final class GetAvailableChatPartnersHandler implements QueryHandler
{
    public function __construct(
        private PersonalChatRepositoryInterface $personalChatRepository,
        private ChatParticipantRepositoryInterface $chatParticipantRepository,
    ){}

    public function __invoke(GetAvailableChatPartnersQuery $query): array
    {
        $participantId = $query->getChatParticipant()->getId();
        $excludeIds = $this->personalChatRepository->findAllPartners($participantId);
        $excludeIds[] = $participantId;

        return $this->chatParticipantRepository->getAllExcept($excludeIds);
    }
}
