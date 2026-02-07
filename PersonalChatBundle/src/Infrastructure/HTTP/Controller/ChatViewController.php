<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Participant\Query\GetAvailableChatPartnersQuery;
use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;
use PersonalChatBundle\Infrastructure\HTTP\DTO\AvailablePartnersResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ChatViewController extends AbstractController
{

    public function __construct(
        private readonly PersonalChatRepositoryInterface $personalChatRepository,
        private readonly QueryBus $queryBus,
        private readonly ParameterBagInterface $params
    ) {
    }


    #[Route('/personal-chat/chat/view', name: 'personal_chat_view', methods: ['GET'])]
    public function openChat() : Response
    {
        //TODO get participant from current user from Request

       //$chatId = 1;
       //$participantId = 3;
        $userId = 1;
        $wsServerConnection = $this->getWsServerConnection();

        $participant = $this->queryBus->ask(new GetParticipantByUserQuery($userId));
        $participantId = $participant->getId();

        $availableChatPartners = $this->getAvailablePartners($participant);


        $currentUserChats = $this->personalChatRepository->findAllByParticipantId($participantId);

        $latestChatId = 0;
        if (count($currentUserChats) > 0) {
           $latestChat = reset($currentUserChats);
           $latestChatId = $latestChat->getId();
        }


        return $this->render('@PersonalChat/chat.html.twig', [
            'currentParticipantId' => $participantId,
            'title' => 'My personal chats',
            'ws_server_connection' => $wsServerConnection,
            'chats' => $currentUserChats,
            'latestChatId' => $latestChatId,
            'availableChatPartners' => $availableChatPartners
        ]);
    }

    private function getAvailablePartners(ChatParticipant $participant):array
    {
        $participantAvailablePartners = $this->queryBus->ask(
            new GetAvailableChatPartnersQuery($participant)
        );
        $dto = new AvailablePartnersResponseDTO($participantAvailablePartners);
        return $dto->toArray();
    }

    private function getWsServerConnection(): string
    {
        $webSocketHost = $this->params->get('web_socket_host');
        $webSocketPort = $this->params->get('web_socket_port');
        return 'ws' . '://' . $webSocketHost . ':' . $webSocketPort;
    }

}
