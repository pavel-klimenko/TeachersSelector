<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Student\Controller;

use App\Application\Student\Command\MakePaymentCommand;
use App\Application\Teacher\UseCase\GetAllTeachers;
use App\Application\Teacher\UseCase\GetTeacher;
use App\Application\Teacher\UseCase\GetTeacherHtmlData;
use App\Application\Teacher\UseCase\SelectTeachers;
use App\Domain\Entity\Teacher;
use App\Infrastructure\Form\SelectTeachersFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Bus\Command\CommandBus;
use App\Application\Student\Command\MakePaymentCommandHandler;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\StudentRepository;
use Exception;

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

    public function makePayment(Request $request, StudentRepository $studentRepository) : Response
    {
       try {

        dd(121212);
        
            // $currentUser = $studentRepository->getStudent()
            // $sum 

        //    $this->commandBus->dispatch(
        //        new MakePaymentCommand(
        //            user: $request->request->get('sender'),
        //            addressee: $request->request->get('addressee'),
        //            message: $request->request->get('message'),
        //        ),
        //    );
       } catch (Exception $e) {
           //$this->responder->loadError($e->getMessage());
       }
//
//        return $this->responder->response();
    }

}
