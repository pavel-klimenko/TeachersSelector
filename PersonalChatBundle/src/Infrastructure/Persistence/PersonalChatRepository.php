<?php

namespace PersonalChatBundle\Infrastructure\Persistence;

use PersonalChatBundle\Domain\Entity\PersonalChat;
use PersonalChatBundle\Domain\Repository\PersonalChatRepositoryInterface;
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
        $this->entityManager->clear();
    }

    public function delete(PersonalChat $personalChat): void
    {
        $this->entityManager->remove($personalChat);
        $this->entityManager->flush();
    }


    public function getById(int $id): ?PersonalChat
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function existsChatByParticipants(int $participantOneId, int $participantTwoId): bool
    {
        $qb = $this->createQueryBuilder('p');

        $qb->where(
            $qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->eq('p.chatParticipantOne', ':p1'),
                    $qb->expr()->eq('p.chatParticipantTwo', ':p2')
                ),
                $qb->expr()->andX(
                    $qb->expr()->eq('p.chatParticipantOne', ':p2'),
                    $qb->expr()->eq('p.chatParticipantTwo', ':p1')
                )
            )
        )
        ->setParameter('p1', $participantOneId)
        ->setParameter('p2', $participantTwoId);

        return $qb->getQuery()->getOneOrNullResult() !== null;
    }

    public function findAllByParticipantId(int $participantId): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.chatParticipantOne = :id')
            ->orWhere('p.chatParticipantTwo = :id')
            ->setParameter('id', $participantId)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllPartners(int $participantId): array
    {
        // 1. Получаем все чаты, где участвует данный participant
        $chats = $this->createQueryBuilder('chats')
            ->where('chats.chatParticipantOne = :id OR chats.chatParticipantTwo = :id')
            ->setParameter('id', $participantId)
            ->getQuery()
            ->getResult();

        $partners = [];

        // 2. Собираем всех участников, кроме самого participantId
        foreach ($chats as $chat) {
            $participants = $chat->getParticipants();
            [$chatParticipantOne, $chatParticipantTwo] = $participants;

            if ($chatParticipantOne->getId() !== $participantId) {
                $partners[] = $chatParticipantOne->getId();
            }

            if ($chatParticipantTwo->getId() !== $participantId) {
                $partners[] = $chatParticipantTwo->getId();
            }
        }

        return $partners;
    }


}
