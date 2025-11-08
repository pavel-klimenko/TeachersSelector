<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Chats\PersonalChatMessages\Controller;

use App\Application\Chats\PersonalChat\Command\CreateChatCommand;
use App\Application\Chats\PersonalChatMessages\Command\CreatePersonalChatMessageCommand;
use App\Domain\Bus\Command\CommandBus;
use App\Domain\Entity\PersonalChat;
use App\Infrastructure\Repository\PersonalChatRepository;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\TeacherRepository;
use App\Infrastructure\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CommandPersonalChatMessagesController extends AbstractController
{

    public function __construct(
        //private readonly CreateEmailResponder $responder,
        public readonly CommandBus $commandBus,
    ) {
    }

    public function createChatMessage(Request $request, PersonalChatRepository $personalChatRepository, UserRepository $userRepository) : Response
    {
       try {

            dd(12121);


           //TODO get Teacher and Student from Request
           $chat = $personalChatRepository->find(1); //Todo teacher
           $user = $userRepository->find(1); //Todo student
           $message = 'TEST_MESSAGE_TEST_MESSSSAGE';

            $this->commandBus->dispatch(
                new CreatePersonalChatMessageCommand(
                    personalChat: $chat,
                    relatedUser: $user,
                    message: $message
                ),
            );
       } catch (Exception $e) {
           //$this->responder->loadError($e->getMessage());
       }
//
        return new Response(
            '<html><body>createChatMessage: 1</body></html>'
        );
    }

}
