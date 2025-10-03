<?php declare(strict_types=1);

namespace App\Application\Chats\PersonalChat\Command;

use App\Application\Chats\PersonalChat\Factory\PersonalChatFactory;
use App\Domain\Bus\Command\CommandHandler;
use App\Domain\Repository\PersonalChatRepositoryInterface;

class CreateChatCommandHandler implements CommandHandler
{
    public function __construct(
        private PersonalChatRepositoryInterface $personalChatRepository,
    ){}

   public function __invoke(CreateChatCommand $command)  {
        //TODO try catch use in the controller API methods
       try {
           //TODO check here if chat between such student and teacher already exists
           $this->personalChatRepository->save(PersonalChatFactory::makeObject($command));
       } catch (\Throwable $exception) {
           print_r($exception->getMessage());
           throw $exception;
       }
   }
}