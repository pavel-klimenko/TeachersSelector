<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Countries;
final class IsoCode
{
    public function __construct(
        private string $code,
    )
    {
        $this->assertCodeIsValid($code);
    }

    private function assertIsoCodeIsValid($input) {
        //TODO validate using ISO List Array
//        if (!preg_match('/^[a-z0-9]+$/', $input)) {
//            throw new \InvalidArgumentException('Code is invalid');
//        }
    }
}
