<?php

declare(strict_types=1);

namespace PersonalChatBundle\Domain\ValueObject\PersonalChatMessage;

final class Message
{
    public function __construct(
        private string $message,
    )
    {
        $this->assertMessageIsValid($message);
    }

    public function get(): string
    {
        return $this->message;
    }

    private function assertMessageIsValid($message) {
        $pattern = '/^[\p{L}\p{N}\p{P}\p{S}\p{Zs}]+$/u';
        if (!preg_match($pattern, $message)) {
            throw new \InvalidArgumentException('Message has invalid format');
        }
    }
}
