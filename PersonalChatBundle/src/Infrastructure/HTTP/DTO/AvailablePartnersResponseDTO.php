<?php

declare(strict_types=1);

namespace PersonalChatBundle\Infrastructure\HTTP\DTO;

use PersonalChatBundle\Domain\Entity\ChatParticipant;

final readonly class AvailablePartnersResponseDTO
{
    /**
     * @param ChatParticipant[] $participants
     */
    public function __construct(
        private array $participants
    ) {}

    public function toArray(): array
    {
        return array_map(
            fn(ChatParticipant $participant) => [
                'id' => $participant->getId(),
                'name' => $participant->getName(),
            ],
            $this->participants
        );
    }
}

