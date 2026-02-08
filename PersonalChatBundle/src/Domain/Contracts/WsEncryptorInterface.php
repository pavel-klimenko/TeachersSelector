<?php

declare(strict_types=1);

namespace PersonalChatBundle\Domain\Contracts;

interface WsEncryptorInterface
{
    public function encrypt(
        #[\SensitiveParameter] string $secretKey,
        #[\SensitiveParameter] string $sessionId
    ):string;

    public function decrypt(
        #[\SensitiveParameter] string $secretKey,
        #[\SensitiveParameter] string $token
    ):?string;
}