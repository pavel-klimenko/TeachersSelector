<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Application\Chats\Participant\Query\GetAvailableChatPartnersQuery;
use PersonalChatBundle\Infrastructure\HTTP\DTO\AvailablePartnersResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/personal-chat/get-available-partners', name: 'personal_chat_get_get_available_partners', methods: ['GET'])]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class GetAvailableChatPartnersController extends AbstractController
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function __invoke():JsonResponse
    {
        try {
            $currentUserId = $this->getUser()->getId();

            $participant = $this->queryBus->ask(new GetParticipantByUserQuery($currentUserId));

            $participantAvailablePartners = $this->queryBus->ask(
                new GetAvailableChatPartnersQuery($participant)
            );

            $dto = new AvailablePartnersResponseDTO($participantAvailablePartners);

            return new JsonResponse(['available_partners' => $dto->toArray()],
                Response::HTTP_OK);

        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

