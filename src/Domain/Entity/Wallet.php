<?php

namespace App\Domain\Entity;

use App\Domain\Enums\Currencies;
use App\Domain\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'currency', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(enumType: Currencies::class)]
    private ?Currencies $currency = null;

    #[ORM\Column]
    private ?float $cash = null;

    #[ORM\OneToOne(mappedBy: 'source_wallet_id', cascade: ['persist', 'remove'])]
    private ?Payment $target_wallet_id = null;

    #[ORM\OneToOne(mappedBy: 'target_wallet_id', cascade: ['persist', 'remove'])]
    private ?Payment $sum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCurrency(): ?Currencies
    {
        return $this->currency;
    }

    public function setCurrency(Currencies $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCash(): ?float
    {
        return $this->cash;
    }

    public function setCash(float $cash): static
    {
        $this->cash = $cash;

        return $this;
    }

    public function getTargetWalletId(): ?Payment
    {
        return $this->target_wallet_id;
    }

    public function setTargetWalletId(Payment $target_wallet_id): static
    {
        // set the owning side of the relation if necessary
        if ($target_wallet_id->getSourceWalletId() !== $this) {
            $target_wallet_id->setSourceWalletId($this);
        }

        $this->target_wallet_id = $target_wallet_id;

        return $this;
    }

    public function getSum(): ?Payment
    {
        return $this->sum;
    }

    public function setSum(Payment $sum): static
    {
        // set the owning side of the relation if necessary
        if ($sum->getTargetWalletId() !== $this) {
            $sum->setTargetWalletId($this);
        }

        $this->sum = $sum;

        return $this;
    }
}
