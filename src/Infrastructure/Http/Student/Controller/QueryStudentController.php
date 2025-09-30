<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Student\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


final class QueryStudentController extends AbstractController
{

    // public function __construct(
    //     private GetPaymentResponse $responder,
    //     private QueryBus $queryBus,
    // ) {
    // }

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
