<?php

namespace App\Application\Chats\PersonalChatMessages\Command;

use App\Domain\Bus\Command\Command;
use App\Domain\Entity\PersonalChat;
use App\Domain\Entity\User;


final class CreatePersonalChatMessageCommand implements Command
{
    public function __construct(
        private readonly PersonalChat $personalChat,
        private readonly User $relatedUser,
        private readonly string $message,
    ) {
    }

   public function personalChat(): PersonalChat
   {
       return $this->personalChat;
   }

    public function relatedUser(): User
    {
        return $this->relatedUser;
    }

    public function message(): string
    {
        return $this->message;
    }

}