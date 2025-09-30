<?php declare(strict_types=1);

namespace App\Application\PaymentType\DTO;

use App\Domain\DTO\CreateDTOInterface;

final class CreatePaymentTypeDTO implements CreateDTOInterface
{
    public readonly string $name;
    public readonly string $code;
    public function __construct(
        string $name,
        string $code,
    )
    {
        $this->name = $name;
        $this->code = $code;
    }
}