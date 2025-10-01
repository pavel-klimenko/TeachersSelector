<?php

namespace App\Domain\Entity;

use App\Domain\Enums\PaymentStatuses;
use App\Infrastructure\Repository\PaymentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[HasLifecycleCallbacks]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Wallet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $source_wallet = null;

    #[ORM\ManyToOne(targetEntity: Wallet::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $target_wallet = null;

    #[ORM\Column]
    private ?float $sum = null;

    #[ORM\Column(enumType: PaymentStatuses::class)]
    private ?PaymentStatuses $status = PaymentStatuses::IN_PROCESS;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceWallet(): ?Wallet
    {
        return $this->source_wallet;
    }

    public function setSourceWallet(Wallet $source_wallet): static
    {
        $this->source_wallet = $source_wallet;

        return $this;
    }

    public function getTargetWallet(): ?Wallet
    {
        return $this->target_wallet;
    }

    public function setTargetWallet(Wallet $target_wallet): static
    {
        $this->target_wallet = $target_wallet;

        return $this;
    }

    public function getSum(): ?float
    {
        return $this->sum;
    }

    public function setSum(float $sum): static
    {
        $this->sum = $sum;

        return $this;
    }

    public function getStatus(): ?PaymentStatuses
    {
        return $this->status;
    }

    public function setStatus(PaymentStatuses $status): static
    {
        $this->status = $status;
        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }
}
