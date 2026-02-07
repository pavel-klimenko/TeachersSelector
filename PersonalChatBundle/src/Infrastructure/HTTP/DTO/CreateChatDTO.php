<?php

namespace PersonalChatBundle\Infrastructure\HTTP\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateChatDTO
{
    #[Assert\Type(type: 'numeric')]
    #[Assert\Positive]
    public mixed $partnerId;

    public function __construct(mixed $partnerId)
    {
        $this->partnerId = $partnerId;
    }
}
