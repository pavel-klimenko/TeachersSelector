<?php declare(strict_types=1);

namespace PersonalChatBundle\Domain\Repository;

use PersonalChatBundle\Domain\Entity\PersonalChat;

interface PersonalChatRepositoryInterface
{
    public function save(PersonalChat $personalChat): void;

    public function delete(PersonalChat $personalChat): void;

    public function getById(int $id): ?PersonalChat;

    public function existsChatByParticipants(int $participantOneId, int $participantTwoId): bool;

    public function findAllByParticipantId(int $participantId): array;

    public function findAllPartners(int $participantId): array;
}
