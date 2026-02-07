<?php declare(strict_types=1);

namespace PersonalChatBundle\Domain\Repository;

use PersonalChatBundle\Domain\Entity\PersonalChatMessage;

interface PersonalChatMessagesRepositoryInterface
{
    public function save(PersonalChatMessage $personalChatMessage): void;
}