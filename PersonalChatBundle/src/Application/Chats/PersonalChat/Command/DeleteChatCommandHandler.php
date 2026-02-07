<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\PersonalChat\Command;

use PersonalChatBundle\Domain\Bus\Command\CommandHandler;
use PersonalChatBundle\Domain\Entity\PersonalChat;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;

class DeleteChatCommandHandler implements CommandHandler
{
    public function __construct(
        private PersonalChatRepositoryInterface $personalChatRepository,
        private ChatParticipantRepositoryInterface $chatParticipantRepository,
    ){}


   public function __invoke(DeleteChatCommand $command)  {
       try {
           $chat = $this->personalChatRepository->getById($command->getChat());

           if ($chat === null) {
               throw new \LogicException(sprintf('Chat with id %d not found', $command->getChat()));
           }

           $chatParticipants = $chat->getParticipants();


           $arParticipants = [];
           foreach ($chatParticipants as $participant) {
               $arParticipants[] = $participant->getId();
           }


           if (!in_array($command->getParticipantWhoWantDelete(), $arParticipants)) {
               throw new \LogicException(sprintf('This user is not participant of chat'));
           }

           $this->personalChatRepository->delete($chat);

       } catch (\Throwable $exception) {
           print_r($exception->getMessage());
           throw $exception;
       }
   }
}
