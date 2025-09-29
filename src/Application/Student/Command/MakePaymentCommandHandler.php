<?php
declare(strict_types=1);

namespace App\Application\Student\Command;

use App\Domain\Bus\Command\CommandHandler;

class MakePaymentCommandHandler implements CommandHandler
{
//    public function __construct(private EmailRepository $repository)
//    {
//    }

   public function __invoke(MakePaymentCommand $command)  {


        dd($command);

    //    $email = Email::createNewEmail(
    //        sender: new EmailAddress($command->sender()),
    //        addressee: new EmailAddress($command->addressee()),
    //        message: new Message($command->message()),
    //    );

       //TODO here we will create payment transaction
    //    $this->repository->save($email);
    //    return $email->id();
   }
}