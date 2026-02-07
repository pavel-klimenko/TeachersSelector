<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Application\Chats\PersonalChat\Command\CreateChatCommand;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use PersonalChatBundle\Infrastructure\HTTP\DTO\CreateChatDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PersonalChatBundle\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/personal-chat/chat', name: 'personal_chat_create', methods: ['POST'])]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class CreateChatController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CreateChatDTO $dto)
    {
        try {
            $currentUserId = $this->getUser()->getId();
            $currentParticipantId = $this->queryBus->ask(new GetParticipantByUserQuery($currentUserId))->getId();

            $createChatCommand = new CreateChatCommand($currentParticipantId, $dto->partnerId);
            $this->commandBus->dispatch($createChatCommand);
            return new JsonResponse(['status' => 'Chat created'], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
