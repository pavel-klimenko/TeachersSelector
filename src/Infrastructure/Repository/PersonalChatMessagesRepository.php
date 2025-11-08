<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\PersonalChatMessage;
use App\Domain\Repository\PersonalChatMessagesRepositoryInterface;
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

    public function save(PersonalChatMessage $personalChatMessage): PersonalChatMessage
    {
        $this->entityManager->persist($personalChatMessage);
        $this->entityManager->flush();
        $this->entityManager->clear();
        return $personalChatMessage;
    }

}
