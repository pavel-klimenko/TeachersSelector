<?php

declare(strict_types=1);

namespace PersonalChatBundle\Application\Processors;

use PersonalChatBundle\Domain\Entity\PersonalChatMessage;

interface ChatMessageProcessorInterface
{
    public function process(PersonalChatMessage $message, callable $next): PersonalChatMessage;
}