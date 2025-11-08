<?php

namespace App\Infrastructure\Services;

use App\Domain\Entity\User;
use App\Domain\Entity\PersonalChat;
use App\Infrastructure\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Enums\UserRoles;
use App\Infrastructure\Repository\UserRepository;
use RuntimeException;


class PersonalChatService
{
     public function loadChat(int $targetChatId, User $user):array
     {
        $currentUserId = $user->getId();

        if (in_array(UserRoles::ROLE_STUDENT->name, $user->getRoles())) {
                $student = $user->getStudent();
                $personalChats = $student->getPersonalChats();
            } elseif (in_array(UserRoles::ROLE_TEACHER->name, $user->getRoles())) {
                $techer = $user->getTeacher();
                $personalChats = $techer->getPersonalChats();
            }

            $chatForLoad = NULL;
            foreach ($personalChats as $chat) {
                if ($chat->getId() == $targetChatId) {
                    $chatForLoad = $chat;
                } 
            }

            if (is_null($chatForLoad)) {
                throw new RuntimeException('Target chat not found');
            }


            //dump($chatForLoad);
            //Make WS Chat Object

            $arWSChat = [];

            $arChatMessages = $chatForLoad->getPersonalChatMessages()->toArray();
            if (!empty($arChatMessages)) {
                $chatId = $chatForLoad->getId();

                $arWSChat['EVENT'] = 'load_chat';
                $arWSChat['CHAT_ID'] = $chatId;
                $arWSChat['CHANNEL'] = 'personal_chat_'.$chatId;

                foreach ($arChatMessages as $message) {
                    $ownerOfMessageId = $message->getRelatedUser()->getId();

                    if ($ownerOfMessageId == $currentUserId) {
                        $messageType = 'my';
                    } else {
                        $messageType = 'partner';
                    }

                    $messageOwnerID = $message->getRelatedUser()->getId();
                    $messageOwnerName = $message->getRelatedUser()->getName();

                    $arWSChat['MESSAGES'][] = [
                        'OWNER_ID' => $messageOwnerID,
                        'OWNER_NAME' => $messageOwnerName,
                        'TYPE' => $messageType,
                        'TEXT' => $message->getMessage(),
                    ];
                }
            }

        return $arWSChat;
          
     }

     public function addMessageToChat(PersonalChat $personalChat, int $messageSenderId, string $messageText)
     {
        echo $messageSenderId;
        echo $messageText;

        //TODO add message and relate to chat!
        //than return chat!
        



     }

}