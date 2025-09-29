<?php

namespace App\Domain\Entity;

use App\Domain\Enums\PaymentStatuses;
use App\Domain\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
class Payment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'target_wallet_id', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $source_wallet_id = null;

    #[ORM\OneToOne(inversedBy: 'sum', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wallet $target_wallet_id = null;

    #[ORM\Column]
    private ?float $sum = null;

    #[ORM\Column(enumType: PaymentStatuses::class)]
    private ?PaymentStatuses $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSourceWalletId(): ?Wallet
    {
        return $this->source_wallet_id;
    }

    public function setSourceWalletId(Wallet $source_wallet_id): static
    {
        $this->source_wallet_id = $source_wallet_id;

        return $this;
    }

    public function getTargetWalletId(): ?Wallet
    {
        return $this->target_wallet_id;
    }

    public function setTargetWalletId(Wallet $target_wallet_id): static
    {
        $this->target_wallet_id = $target_wallet_id;

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
}
