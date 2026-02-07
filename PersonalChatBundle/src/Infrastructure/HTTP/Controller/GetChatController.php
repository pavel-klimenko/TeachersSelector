<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Message\Factory\ChatMessagesFactory;
use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Application\Chats\PersonalChat\Query\GetPersonalChatQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use PersonalChatBundle\Infrastructure\HTTP\DTO\ChatResponseDTO;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/personal-chat/chat/{chatId}', name: 'personal_chat_get', methods: ['GET'])]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class GetChatController extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function __invoke($chatId):JsonResponse
    {
        try {
            $currentUserId = $this->getUser()->getId();
            $currentParticipantId = $this->queryBus->ask(new GetParticipantByUserQuery($currentUserId))->getId();

            $personalChat = $this->queryBus->ask(new GetPersonalChatQuery((int)$chatId, $currentParticipantId));

            $responseDto = new ChatResponseDTO(
                $personalChat['chat_id'],
                $personalChat['participant_one'],
                $personalChat['participant_two']
            );

            return new JsonResponse([
                'chat' => $responseDto->toArray(),
                'messages' => $personalChat['messages']
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
