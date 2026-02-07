<?php

namespace App\Domain\Entity;

use App\Domain\Enums\Currencies;
use App\Infrastructure\Repository\WalletRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WalletRepository::class)]
class Wallet
{
    const DEFAULT_CURRENCY = Currencies::USD;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'wallet', cascade: ['persist', 'remove'])]
    private ?User $relatedUser = null;

    #[ORM\Column(nullable: true, enumType: Currencies::class)]
    private ?Currencies $currency = null;

    #[ORM\Column(nullable: true)]
    private ?float $cash = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelatedUser(): ?User
    {
        return $this->relatedUser;
    }

    public function setRelatedUser(?User $relatedUser): static
    {
        $this->relatedUser = $relatedUser;

        return $this;
    }

    public function getCurrency(): ?Currencies
    {
        return $this->currency;
    }

    public function setCurrency(?Currencies $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCash(): ?float
    {
        return $this->cash;
    }

    public function setCash(?float $cash): static
    {
        $this->cash = $cash;

        return $this;
    }
}
