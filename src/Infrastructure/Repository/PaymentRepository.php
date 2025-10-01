<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Payment;
use App\Domain\Repository\PaymentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Payment>
 */
class PaymentRepository extends ServiceEntityRepository implements PaymentRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Payment::class);
    }

    public function save(Payment $payment): Payment
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
        return $payment;
    }
}
