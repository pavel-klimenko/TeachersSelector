<?php declare(strict_types=1);

namespace App\Application\Student\Query;

use App\Domain\Bus\Query\QueryHandler;

final class GetPaymentHandler implements QueryHandler
{
    public function __construct(private EmailRepository $repository)
    {
    }

//    public function __invoke(FindEmailQuery $query) : FindEmailResponse
//    {
//        $email = $this->repository->findById(
//            EmailId::fromInt(
//                $query->id(),
//            ),
//        );
//
//        if ($email === null) {
//            throw new InvalidArgumentException('Email unreachable');
//        }
//
//        return new FindEmailResponse(
//            email: $email,
//        );
//    }
}
