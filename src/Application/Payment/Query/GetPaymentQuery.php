<?php declare(strict_types=1);

namespace App\Application\Payment\Query;

use App\Domain\Bus\Query\Query;

final class GetPaymentQuery implements Query
{
    public function __construct(private readonly int $id)
    {
    }

    public function id() : int
    {
        return $this->id;
    }
}

