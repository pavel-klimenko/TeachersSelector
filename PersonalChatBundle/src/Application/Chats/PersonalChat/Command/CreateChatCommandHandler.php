<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\PersonalChat\Command;

use PersonalChatBundle\Domain\Bus\Command\CommandHandler;
use PersonalChatBundle\Domain\Entity\PersonalChat;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;
use PersonalChatBundle\Application\Chats\PersonalChat\Command\CreateChatCommand as CreateChatCommand;

class CreateChatCommandHandler implements CommandHandler
{
    public function __construct(
        private PersonalChatRepositoryInterface $personalChatRepository,
        private ChatParticipantRepositoryInterface $chatParticipantRepository,
    ){}


   public function __invoke(CreateChatCommand $command)  {
       try {
            $participantOneId = $command->getParticipantOne();
            $participantTwoId = $command->getParticipantTwo();

           $participantOne = $this->chatParticipantRepository->getById($participantOneId);
           $participantTwo = $this->chatParticipantRepository->getById($participantTwoId);
           if (!$participantOne || !$participantTwo) {
               throw new \DomainException('One or both participants not found');
           }

           if ($this->personalChatRepository->existsChatByParticipants($participantOneId, $participantTwoId)) {
               throw new \LogicException(sprintf('Chat with %d and %d already exists', $participantOneId, $participantTwoId));
           }

           $this->personalChatRepository->save(new PersonalChat($participantOne, $participantTwo));

       } catch (\Throwable $exception) {
           print_r($exception->getMessage());
           throw $exception;
       }
   }
}
