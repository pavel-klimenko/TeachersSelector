<?php declare(strict_types=1);

namespace App\Application\Chats\PersonalChatMessages\Command;

use App\Application\Chats\PersonalChatMessages\Factory\PersonalChatMessageFactory;
use App\Domain\Bus\Command\CommandHandler;
use App\Domain\Repository\PersonalChatMessagesRepositoryInterface;

class CreatePersonalChatMessageCommandHandler implements CommandHandler
{
    public function __construct(
        public PersonalChatMessagesRepositoryInterface $personalChatMessagesRepository,
    ){}

   public function __invoke(CreatePersonalChatMessageCommand $command)  {
        //TODO try catch use in the controller API methods
       try {
           //TODO check here if user is participient of this chat
           $this->personalChatMessagesRepository->save(PersonalChatMessageFactory::makeObject($command));
       } catch (\Throwable $exception) {
           print_r($exception->getMessage());
           throw $exception;
       }
   }
}