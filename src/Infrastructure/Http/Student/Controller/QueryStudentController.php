<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Student\Controller;

use App\Application\Student\Command\MakePaymentCommand;
use App\Application\Student\Query\GetPaymentResponse;
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

final class QueryStudentController extends AbstractController
{

    public function __construct(
        private GetPaymentResponse $responder,
        private QueryBus $queryBus,
    ) {
    }

    public function getPayment(Request $request, int $id) : Response
    {
//        try {
//            /** @var FindEmailResponse $findEmailResponse */
//            $findEmailResponse = $this->queryBus->ask(
//                new FindEmailQuery(id: $id)
//            );
//
//            $email = $findEmailResponse->email();
//
//            $this->responder->loadEmail($email);
//        } catch (Exception $e) {
//            $this->responder->loadError($e->getMessage());
//        }
//
//        return $this->responder->response();
    }

}
