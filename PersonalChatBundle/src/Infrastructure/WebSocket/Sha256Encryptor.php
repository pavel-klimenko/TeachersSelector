<?php

namespace PersonalChatBundle\Infrastructure\WebSocket;

use PersonalChatBundle\Domain\Contracts\WsEncryptorInterface;

class Sha256Encryptor implements WsEncryptorInterface
{
    public function encrypt(string $secretKey, string $sessionId):string
    {
        $ts = time();
        $payload = $sessionId . '|' . time();
        $signature = hash_hmac('sha256', $payload, $secretKey);
        return base64_encode($sessionId . ':' . $ts . ':' . $signature);
    }

    public function decrypt(string $secretKey, string $token):?string
    {
        $decoded = base64_decode($token, true);
        if (!$decoded) return null;

        [$sessionId, $ts, $signature] = explode(':', $decoded) + [null, null, null];
        if (!$sessionId || !$ts || !$signature) return null;

        if (abs(time() - (int)$ts) > 60) return null;

        $payload = $sessionId . '|' . $ts;
        $expected = hash_hmac('sha256', $payload, $secretKey);

        if (!hash_equals($expected, $signature)) return null;

        return $sessionId;
    }
}