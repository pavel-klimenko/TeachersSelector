<?php

namespace App\Application\Chats\PersonalChat\Factory;

use App\Application\Chats\PersonalChat\Command\CreateChatCommand;
use App\Domain\Entity\PersonalChat;

class PersonalChatFactory
{
    public static function makeObject(CreateChatCommand $createChatCommand): PersonalChat
    {
        $chat = new PersonalChat();
        $chat->setStudent($createChatCommand->student())
            ->setTeacher($createChatCommand->teacher());

        return $chat;
    }
}