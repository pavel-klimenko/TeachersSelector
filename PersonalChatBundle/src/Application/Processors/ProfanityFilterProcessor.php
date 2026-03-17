<?php

declare(strict_types=1);

namespace PersonalChatBundle\Application\Processors;

use PersonalChatBundle\Attribute\ChatProcessor;
use PersonalChatBundle\Domain\Entity\PersonalChatMessage;
use PersonalChatBundle\Domain\ValueObject\PersonalChatMessage\Message as MessageVO;



#[ChatProcessor(priority: 100)]
final class ProfanityFilterProcessor implements ChatMessageProcessorInterface
{
    public function process(PersonalChatMessage $message, callable $next): PersonalChatMessage
    {
        $messageVO = $message->getMessage();
        $text = $messageVO->get();

        $text = preg_replace('/badword/i', '***', $text);

        $newText = new MessageVO($text);
        $message->setMessage($newText);
        return $next($message);
    }
}
