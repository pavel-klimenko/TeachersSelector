<?php declare(strict_types=1);

namespace PersonalChatBundle\Domain\Repository;

use PersonalChatBundle\Domain\Entity\ChatParticipant;

interface ChatParticipantRepositoryInterface
{
    public function save(ChatParticipant $chatChatParticipant): void;

    public function getList(): array;

    public function getById(int $id): ?ChatParticipant;

    public function getParticipantByUserId(int $userId): ?ChatParticipant;

    public function getAllExcept(array $excludedIds): array;
}
