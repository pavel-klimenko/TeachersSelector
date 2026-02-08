<?php declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\Controller;

use PersonalChatBundle\Application\Chats\Participant\Query\GetAvailableChatPartnersQuery;
use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantByUserQuery;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;
use PersonalChatBundle\Domain\Contracts\WsEncryptorInterface;
use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;
use PersonalChatBundle\Infrastructure\HTTP\DTO\AvailablePartnersResponseDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
final class ChatViewController extends AbstractController
{

    public function __construct(
        private readonly PersonalChatRepositoryInterface $personalChatRepository,
        private readonly QueryBus $queryBus,
        private readonly ParameterBagInterface $params,
        private WsEncryptorInterface $encryptor
    ) {
    }


    #[Route('/personal-chat/chat/view', name: 'personal_chat_view', methods: ['GET'])]
    public function openChat() : Response
    {
        $currentUser = $this->getUser();
        if (!$currentUser) {
            return $this->redirectToRoute('app_login');
        }
        $currentUserId = $this->getUser()->getId();


        $participant = $this->queryBus->ask(new GetParticipantByUserQuery($currentUserId));



        $participantId = $participant->getId();

        $availableChatPartners = $this->getAvailablePartners($participant);
        $currentUserChats = $this->personalChatRepository->findAllByParticipantId($participantId);

        $latestChatId = $this->getLatestChatId($currentUserChats);

        return $this->render('@PersonalChat/chat.html.twig', [
            'currentParticipantId' => $participantId,
            'title' => 'My personal chats',
            'ws_server_connection' => $this->getWsServerConnection(),
            'chats' => $currentUserChats,
            'latestChatId' => $latestChatId,
            'availableChatPartners' => $availableChatPartners,
            'wsAuthToken' => $this->getWsToken()
        ]);
    }


    private function getWsToken() {
        $secret = $this->params->get('web_sign_secret');
        return $this->encryptor->encrypt($secret, session_id());
    }


    private function getLatestChatId(array $currentUserChats):int
    {
        $latestChatId = 0;
        if (count($currentUserChats) > 0) {
            $latestChat = reset($currentUserChats);
            $latestChatId = $latestChat->getId();
        }

        return $latestChatId;
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
