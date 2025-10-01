<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\PersonalChatMessages;
use App\Domain\Repository\PersonalChatMessagesRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonalChatMessages>
 */
class PersonalChatMessagesRepository extends ServiceEntityRepository implements PersonalChatMessagesRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalChatMessages::class);
    }

    public function save(PersonalChatMessages $personalChatMessage): void
    {
        $this->entityManager->persist($personalChatMessage);
        $this->entityManager->flush();
    }

}
