<?php

namespace PersonalChatBundle\Infrastructure\Persistence;

use PersonalChatBundle\Domain\Entity\PersonalChatMessage;
use PersonalChatBundle\Domain\Repository\PersonalChatMessagesRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonalChatMessage>
 */
class PersonalChatMessagesRepository extends ServiceEntityRepository implements PersonalChatMessagesRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, PersonalChatMessage::class);
    }

    public function save(PersonalChatMessage $personalChatMessage): void
    {
        $this->entityManager->persist($personalChatMessage);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

}
