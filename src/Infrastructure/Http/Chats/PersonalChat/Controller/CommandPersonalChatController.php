<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Chats\PersonalChat\Controller;

use App\Application\Chats\PersonalChat\Command\CreateChatCommand;
use App\Domain\Bus\Command\CommandBus;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\TeacherRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CommandPersonalChatController extends AbstractController
{

    public function __construct(
        //private readonly CreateEmailResponder $responder,
        private readonly CommandBus $commandBus,
    ) {
    }

    public function createChat(Request $request, TeacherRepository $teacherRepository, StudentRepository $studentRepository) : Response
    {
       try {
           //TODO get Teacher and Student from Request
           $student = $studentRepository->find(1); //Todo teacher
           $teacher = $teacherRepository->find(1); //Todo student

            $this->commandBus->dispatch(
                new CreateChatCommand(
                    student: $student,
                    teacher: $teacher,
                ),
            );
       } catch (Exception $e) {
           //$this->responder->loadError($e->getMessage());
       }
//
        return new Response(
            '<html><body>createChat: 1</body></html>'
        );
    }

}
