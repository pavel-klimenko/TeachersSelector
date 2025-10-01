<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Student\Controller;

use App\Application\Payment\Query\GetPaymentQuery;
use App\Application\Payment\Query\GetPaymentQueryResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Domain\Bus\Query\QueryBus;


final class QueryStudentController extends AbstractController
{
     public function __construct(
         //private GetPaymentResponse $responder,
         private QueryBus $queryBus,
     ) {
     }

    public function getPayment(Request $request) : Response
    {
        try {
            $paymentId = 28;
            /** @var GetPaymentQueryResponse $getPaymentQueryResponse */
            $getPaymentQueryResponse = $this->queryBus->ask(
                new GetPaymentQuery(id: $paymentId)
            );

            dd($getPaymentQueryResponse);

//            $email = $findEmailResponse->email();
//            $this->responder->loadEmail($email);

        } catch (Exception $e) {
            //$this->responder->loadError($e->getMessage());
        }

        return new Response(
            '<html><body>QUERY_RESPONSE1</body></html>'
        );

        //return $this->responder->response();
    }

}
