<?php declare(strict_types=1);

namespace App\Application\Payment\DTO;

use App\Domain\Enums\Currencies;

final readonly class RegisterPaymentDTO
{
    public float $sum;

    public Currencies $currency;
    public string $userEmail;
    public string $userName;

    public function __construct($sum, $currency, $userEmail, $userName)
    {
        $this->sum = $sum;
        $this->currency = $currency;
        $this->userEmail = $userEmail;
        $this->userName = $userName;
    }
}