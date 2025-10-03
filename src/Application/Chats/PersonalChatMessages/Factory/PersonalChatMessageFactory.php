<?php

namespace App\Application\Chats\PersonalChatMessages\Factory;

use App\Application\Chats\PersonalChatMessages\Command\CreatePersonalChatMessageCommand;
use App\Domain\Entity\PersonalChatMessage;

class PersonalChatMessageFactory
{
    public static function makeObject(CreatePersonalChatMessageCommand $createPersonalChatMessageCommand): PersonalChatMessage
    {
        $newMessage = new PersonalChatMessage();
        $newMessage->setPersonalChat($createPersonalChatMessageCommand->personalChat())
            ->setRelatedUser($createPersonalChatMessageCommand->relatedUser())
            ->setMessage($createPersonalChatMessageCommand->message());
        return $newMessage;
    }
}