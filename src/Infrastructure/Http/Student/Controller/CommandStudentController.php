<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Student\Controller;

use App\Application\Payment\Command\MakePaymentCommand;
use App\Domain\Bus\Command\CommandBus;
use App\Infrastructure\Repository\UserRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CommandStudentController extends AbstractController
{

//    private array $teacherHtmlData;
//
//    public function __construct(
//        private GetAllTeachers $getAllTeachersCase,
//        private GetTeacher         $getOneCase,
//        private SelectTeachers         $selectCase,
//        private GetTeacherHtmlData         $GetTeacherHtmlDataCase,
//    ){
//        $this->teacherHtmlData = $this->GetTeacherHtmlDataCase->execute();
//    }

    public function __construct(
        //private readonly CreateEmailResponder $responder,
        private readonly CommandBus $commandBus,
    ) {
    }

    public function makePayment(Request $request, UserRepository $userRepository) : Response
    {
       try {
           //TODO get User and sum from Request

           $currentUser = $userRepository->find(1); //Todo student
           $sum = 20; //

           $targetUser = $userRepository->find(9); //Todo teacher
           //$sourceWallet = $currentUser->getWallet();

           //TODO commands are already DTO. Don`t use DTO together with commands

            $this->commandBus->dispatch(
                new MakePaymentCommand(
                    sourceUser: $currentUser,
                    targetUser: $targetUser,
                    sum: $sum
                ),
            );
       } catch (Exception $e) {
           //$this->responder->loadError($e->getMessage());
       }
//
        return new Response(
            '<html><body>Lucky number: 1</body></html>'
        );
    }

}
