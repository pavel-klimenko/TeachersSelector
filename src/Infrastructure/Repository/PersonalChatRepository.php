<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\PersonalChat;
use App\Domain\Repository\PersonalChatRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<PersonalChat>
 */
class PersonalChatRepository extends ServiceEntityRepository implements PersonalChatRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, PersonalChat::class);
    }

    public function save(PersonalChat $personalChat): void
    {
        $this->entityManager->persist($personalChat);
        $this->entityManager->flush();
    }
}

