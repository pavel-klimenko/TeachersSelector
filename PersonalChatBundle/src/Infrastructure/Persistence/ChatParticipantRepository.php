<?php

namespace PersonalChatBundle\Infrastructure\Persistence;

use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Repository\ChatParticipantRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChatParticipant>
 */
class ChatParticipantRepository extends ServiceEntityRepository implements ChatParticipantRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, ChatParticipant::class);
    }

    public function save(ChatParticipant $chatParticipant): void
    {
        $this->entityManager->persist($chatParticipant);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function getById(int $id): ?ChatParticipant
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function getParticipantByUserId(int $userId): ?ChatParticipant
    {
        return $this->createQueryBuilder('p')
            ->join('p.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param int[] $excludedIds
     * @return ChatParticipant[]
     */
    public function getAllExcept(array $excludedIds): array
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($excludedIds)) {
            $qb->andWhere('p.id NOT IN (:ids)')
                ->setParameter('ids', $excludedIds);
        }

        return $qb->getQuery()->getResult();
    }


}
