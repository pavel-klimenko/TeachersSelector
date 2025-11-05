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

final class ChatController extends AbstractController
{
    public function openChat(Request $request) : Response
    {
        $user = $this->getUser();
        $arCurrentUserRoles = $user->getRoles();

        $arPersonalChats = [];

        if (in_array(UserRoles::ROLE_STUDENT->name, $arCurrentUserRoles)) {
            //dump('STUDENT');

            $student = $user->getStudent();
            $arUserPersonalChats = $student->getPersonalChats();
            foreach ($arUserPersonalChats as $chat) {
                $chatId = $chat->getId();
                $chatPartnerName = $chat->getTeacher()->getRelatedUser()->getName();
                $arPersonalChats[$chatId] = $chatPartnerName;
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


        //dd($arPersonalChats);

        return $this->render('chats/chat.html.twig', [
            'title' => 'My personal chats',
            'chats' => $arPersonalChats
        ]);
    }

}
