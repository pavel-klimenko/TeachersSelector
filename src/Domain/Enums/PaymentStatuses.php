<?php

namespace App\Domain\Enums;

enum PaymentStatuses: string
{
    case IN_PROCESS = 'in_process';
    case CANCELED = 'canceled';
    case APPROVED = 'approved';
}