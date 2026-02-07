<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Application\Chats\PersonalChat\Command\DeleteChatCommand;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use PersonalChatBundle\Domain\Bus\Command\CommandBus;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/personal-chat/chat/{chatId}', name: 'personal_chat_delete', methods: ['DELETE'])]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class DeleteChatController extends AbstractController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke($chatId)
    {
        try {
            $currentUserId = $this->getUser()->getId();
            $participant = $this->queryBus->ask(new GetParticipantByUserQuery($currentUserId));

            $createChatCommand = new DeleteChatCommand((int)$chatId, $participant->getId());
            $this->commandBus->dispatch($createChatCommand);
            return new JsonResponse(['status' => 'Chat deleted'], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
