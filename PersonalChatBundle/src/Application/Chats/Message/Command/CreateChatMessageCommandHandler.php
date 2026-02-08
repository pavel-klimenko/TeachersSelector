<?php declare(strict_types=1);

namespace PersonalChatBundle\Application\Chats\Message\Command;

use DomainException;
use PersonalChatBundle\Application\Chats\Participant\Query\GetParticipantQuery;
use PersonalChatBundle\Application\Chats\PersonalChat\Query\GetPersonalChatQuery;
use PersonalChatBundle\Domain\Bus\Command\CommandHandler;
use PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message\ChatMessageSenderInterface;
use PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message\SendChatMessage;
use PersonalChatBundle\Domain\Bus\Query\QueryBus;


class CreateChatMessageCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private ChatMessageSenderInterface $chatMessageSenderInterface
    ){}

   public function __invoke(CreateChatMessageCommand $command):void
     {
       try {
           $participant = $this->queryBus->ask(new GetParticipantQuery($command->getParticipant()));
           $personalChat = $this->queryBus->ask(new GetPersonalChatQuery($command->getPersonalChat(), $participant->getId()));
           $personalChat = $personalChat['personal_chat'];

           $isParticipantMemberOfChat = false;


           foreach ($personalChat->getParticipants() as $realChatParticipant) {
                if ($participant->getId() === $realChatParticipant->getId()) {
                    $isParticipantMemberOfChat = true;
                }
           }

           if (!$isParticipantMemberOfChat) {
                throw new DomainException(sprintf('Participant with ID %d is not member of the chat', $command->getParticipant()));
           }

           $this->chatMessageSenderInterface->send(new SendChatMessage(
               $personalChat->getId(),
               $participant->getId(),
               $command->getMessage(),
           ));

       } catch (\Throwable $exception) {
           print_r($exception->getMessage());
           throw $exception;
       }
   }
}
