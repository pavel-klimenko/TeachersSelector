<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\PersonalChatMessage;

interface PersonalChatMessagesRepositoryInterface
{
    public function save(PersonalChatMessage $personalChatMessage): PersonalChatMessage;
}