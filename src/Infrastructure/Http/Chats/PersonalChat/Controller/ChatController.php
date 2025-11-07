<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Chats\PersonalChat\Controller;

use App\Application\Chats\PersonalChat\Command\CreateChatCommand;
use App\Domain\Bus\Command\CommandBus;
use App\Domain\Enums\UserRoles;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Infrastructure\Services\PersonalChatService;
use App\Infrastructure\Repository\UserRepository;
use RuntimeException;

final class ChatController extends AbstractController
{
    public function openChat(UserRepository $userRepository, Request $request) : Response
    {

        //TODO add into chatService
        // $channel = 'personal_chat_1';
        // $targetChatId = 1;
        // $currentUserId = 5;

        // $user = $userRepository->find($currentUserId);




    

        //$personalChatService = new PersonalChatService();




        // $wsChatObject = $personalChatService->loadChat($chatId, $currentUserId);



    



        $user = $this->getUser();
        $arCurrentUserRoles = $user->getRoles();

        $arPersonalChats = [];

        if (in_array(UserRoles::ROLE_STUDENT->name, $arCurrentUserRoles)) {
            //dump('STUDENT');

            $student = $user->getStudent();


            //dump($student);

            $arUserPersonalChats = $student->getPersonalChats();
            foreach ($arUserPersonalChats as $chat) {
                $chatId = $chat->getId();
                $chatPartnerName = $chat->getTeacher()->getRelatedUser()->getName();

                $arPersonalChats[$chatId]['partner_name'] = $chatPartnerName;
                $arPersonalChats[$chatId]['ws_channel'] = 'personal_chat_'.$chatId;
                $arPersonalChats[$chatId]['current_user_role'] = UserRoles::ROLE_STUDENT->value;
                $arPersonalChats[$chatId]['current_user_id'] = $user->getId();
            }

        } elseif (in_array(UserRoles::ROLE_TEACHER->name, $arCurrentUserRoles)) {
           // dump('TEACHER');
            $teacher = $user->getTeacher();
            $arUserPersonalChats = $teacher->getPersonalChats();
            foreach ($arUserPersonalChats as $chat) {
                $chatId = $chat->getId();
                $chatPartnerName = $chat->getStudent()->getRelatedUser()->getName();
                $arPersonalChats[$chatId]['partner_name'] = $chatPartnerName;
                $arPersonalChats[$chatId]['ws_channel'] = 'personal_chat_'.$chatId;
            }
        } else {
            throw new \RuntimeException('Unknown user role');
        }



        return $this->render('chats/chat.html.twig', [
            'title' => 'My personal chats',
            'chats' => $arPersonalChats
        ]);
    }

}
