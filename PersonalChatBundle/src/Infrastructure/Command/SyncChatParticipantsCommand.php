<?php

namespace PersonalChatBundle\Infrastructure\Command;

use Doctrine\ORM\EntityManagerInterface;
use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Entity\ChatUserInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'personal-chat:sync-participants',
    description: 'Create ChatParticipant for all Users'
)]
class SyncChatParticipantsCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $userClass = ChatUserInterface::class;

        $userRepo = $this->em->getRepository($userClass);
        $participantRepo = $this->em->getRepository(ChatParticipant::class);

        $users = $userRepo->findAll();


        if (count($users) === 0) {
            $output->writeln("Users not found");
            return Command::SUCCESS;
        }


        $created = 0;
        foreach ($users as $user) {
            // Check if there is already a member for this user
            $existing = $participantRepo->findOneBy(['user' => $user]);
            if ($existing) continue;

            // Create a new participant
            $participant = new ChatParticipant(
                user: $user,
                name: method_exists($user, 'getName') ? $user->getName() : 'User '.$user->getId()
            );

            $this->em->persist($participant);
            $created++;
        }

        $this->em->flush();
        $output->writeln("Created chat participants: $created");

        return Command::SUCCESS;
    }
}
