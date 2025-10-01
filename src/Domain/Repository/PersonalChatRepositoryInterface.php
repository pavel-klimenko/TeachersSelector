<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\PersonalChat;

interface PersonalChatRepositoryInterface
{
    public function save(PersonalChat $personalChat): void;
}