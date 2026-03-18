<?php
declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\Message;

use PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message\SendChatMessage;
use PersonalChatBundle\Application\Processors\ChainChatProcessor;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;
use PersonalChatBundle\Domain\ValueObject\PersonalChatMessage\Message as MessageVO;

#[AsMessageHandler]
final class RabbitMessageHandler
{
    public function __construct(
        private PersonalChatRepositoryInterface $personalChatRepository,
        private ChatParticipantRepositoryInterface $chatParticipantRepository,
        private ChainChatProcessor $chatProcessor,
    ) {}

    public function __invoke(SendChatMessage $dto): void
    {
        $personalChat = $this->personalChatRepository->getById($dto->chatId);
        $chatParticipant = $this->chatParticipantRepository->getById($dto->authorId);

        $message = new MessageVO($dto->message);

        $processedMessage = $this->chatProcessor->handle($message);

//        $personalChat->addMessage($chatParticipant, new MessageVO($dto->message));
//        $this->personalChatRepository->save($personalChat);
    }
}
