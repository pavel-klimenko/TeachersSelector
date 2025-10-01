<?php declare(strict_types=1);

namespace App\Application\Payment\Command;

use App\Application\Payment\DTO\CreatePaymentDTO;
use App\Application\Payment\DTO\ResponsePaymentDTO;
use App\Application\Payment\Factory\PaymentFactory;
use App\Domain\Bus\Command\CommandHandler;
use App\Domain\Enums\PaymentStatuses;
use App\Domain\Repository\PaymentRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface; //TODO use clean architecture

class MakePaymentCommandHandler implements CommandHandler
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private EntityManagerInterface $em,
    ){}

   public function __invoke(MakePaymentCommand $command)  {
        //TODO try catch use in the controller API methods
       try {

           $this->em->beginTransaction(); //TODO use clean architecture

           $sourceWallet = $command->sourceUser()->getWallet();
           $sourceCash = $sourceWallet->getCash();
           $targetWallet = $command->targetUser()->getWallet();
           $sum = $command->sum();

           if ($sourceCash < $sum) {
               throw new \RuntimeException('There is no enough money in the source wallet');
           }

           //Send sum from source wallet to target wallet
           $sourceWallet->setCash($sourceCash - $sum);
           $targetWallet->setCash($targetWallet->getCash() + $sum);

           //Create in_process payment
           $DTO = new CreatePaymentDTO($sourceWallet, $targetWallet, $sum);

           $payment = $this->paymentRepository->save(PaymentFactory::makeObject($DTO));

           //TODO here send to the Payment system and catch response from payment system
           $arPaymentSystemResponse = [];
           $arPaymentSystemResponse['status'] = 'success';

           if ($arPaymentSystemResponse['status'] == 'error') {
               throw new \RuntimeException('Payment system error');
           }

           if ($arPaymentSystemResponse['status'] == 'success') {
               $createdPayment = $this->paymentRepository->find($payment->getId());
               $createdPayment->setStatus(PaymentStatuses::APPROVED);
               $createdPayment = $this->paymentRepository->save($createdPayment);
               $this->em->commit();

               return new ResponsePaymentDTO(
                   $createdPayment->getId(),
                   $createdPayment->getSourceWallet(),
                   $createdPayment->getTargetWallet(),
                   $createdPayment->getSum(),
               );
           }

       } catch (\Throwable $exception) {
           $this->em->rollback();

           print_r($exception->getMessage());
           throw $exception;
       }
   }
}