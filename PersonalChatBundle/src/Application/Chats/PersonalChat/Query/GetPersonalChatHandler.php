<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\PersonalChat\Query;

use DomainException;
use PersonalChatBundle\Application\Chats\Message\Factory\ChatMessagesFactory;
use PersonalChatBundle\Domain\Bus\Query\QueryHandler;
use PersonalChatBundle\Application\Chats\PersonalChat\Query\GetPersonalChatQuery;
use PersonalChatBundle\Domain\Entity\PersonalChat;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;

final class GetPersonalChatHandler implements QueryHandler
{
    public function __construct(
        private PersonalChatRepositoryInterface $personalChatRepository,
    ){}

    public function __invoke(GetPersonalChatQuery $query): array
    {
        $chatId = $query->getChatId();

        $personalChat = $this->personalChatRepository->getById($chatId);

        $messages = (new ChatMessagesFactory($personalChat))->toArray();

        $participants = $personalChat->getParticipants();

        $participantOneId = $participants[0]->getId();
        $participantTwoId = $participants[1]->getId();

        if (!in_array($query->getCurrentParticipant(), [$participantOneId, $participantTwoId])) {
            throw new DomainException('User is not a participant of chat');
        }

        if ($personalChat === null) {
            throw new DomainException(sprintf('Chat with ID %d not found', $chatId));
        }

        return [
            'chat_id' => $personalChat->getId(),
            'participant_one' => $participantOneId,
            'participant_two' => $participantOneId,
            'messages' => $messages
        ];
    }
}