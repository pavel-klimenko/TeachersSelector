<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Message\Command\CreateChatMessageCommand;
use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Infrastructure\HTTP\DTO\CreateChatMessageDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PersonalChatBundle\Domain\Bus\Command\CommandBus;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/personal-chat/message', name: 'chat_message_create', methods: ['POST'])]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CreateChatMessageController extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CreateChatMessageDTO $dto)
    {
        try {
            $currentUserId = $this->getUser()->getId();
            $currentParticipantId = $this->queryBus->ask(new GetParticipantByUserQuery($currentUserId))->getId();

            $this->commandBus->dispatch(new CreateChatMessageCommand(
                $dto->chatId,
                $currentParticipantId,
                $dto->message
            ));
            return new JsonResponse(['status' => 'Chat message created'], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
