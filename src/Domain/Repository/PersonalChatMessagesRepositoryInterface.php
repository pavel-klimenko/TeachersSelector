<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\PersonalChatMessages;

interface PersonalChatMessagesRepositoryInterface
{
    public function save(PersonalChatMessages $personalChatMessage): void;
}