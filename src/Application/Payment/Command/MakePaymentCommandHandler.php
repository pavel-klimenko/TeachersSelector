<?php declare(strict_types=1);

namespace App\Application\Payment\Command;

use App\Application\Payment\DTO\CreatePaymentDTO;
use App\Application\Payment\DTO\ResponsePaymentDTO;
use App\Application\Payment\Factory\PaymentFactory;
use App\Domain\Bus\Command\CommandHandler;
use App\Domain\Repository\PaymentRepositoryInterface;

class MakePaymentCommandHandler implements CommandHandler
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
    ){}

   public function __invoke(MakePaymentCommand $command)  {
       $DTO = new CreatePaymentDTO(
           $command->sourceUser()->getWallet(),
           $command->targetUser()->getWallet(),
           $command->sum()
       );

       $newPayment = $this->paymentRepository->save(PaymentFactory::makeObject($DTO));

       return new ResponsePaymentDTO(
           $newPayment->getId(),
           $newPayment->getSourceWallet(),
           $newPayment->getTargetWallet(),
           $newPayment->getSum(),
       );
   }
}